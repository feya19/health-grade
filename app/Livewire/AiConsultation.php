<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\AiAssistant;
use Illuminate\Support\Facades\Auth;

#[Title('HealthGrade Assistant')]
class AiConsultation extends Component
{
    use WithFileUploads;

    public array $messages = [];
    public string $prompt = '';
    public bool $isStreaming = false;
    public $image;
    public ?string $imagePreview = null;

    public function mount()
    {
        // Load history dari database dan convert ke format messages
        $this->loadHistory();
    }

    public function loadHistory()
    {
        $history = AiAssistant::where('user_id', Auth::id())
            ->whereNull('food_id')
            ->latest()
            ->take(50)
            ->get()
            ->sortBy('id');

        // Convert database history ke format messages
        foreach ($history as $chat) {
            $this->messages[] = [
                'role' => 'user',
                'content' => trim($chat->user_prompt)
            ];
            $this->messages[] = [
                'role' => 'assistant',
                'content' => trim($chat->ai_response)
            ];
        }
    }

    public function sendMessage(?string $messageContent = null)
    {
        $content = $messageContent ?? $this->prompt;
        $content = trim($content);
        
        if (empty($content) && !$this->image) {
            return;
        }

        $messageData = [
            'role' => 'user',
            'content' => []
        ];

        // Add text
        $messageData['content'][] = [
            'type' => 'text',
            'text' => $content ?: 'Jelaskan gambar ini'
        ];

        // Handle image if uploaded
        if ($this->image) {
            try {
                $imagePath = $this->image->store('chat-images', 'public');
                $imageFullPath = storage_path('app/public/' . $imagePath);

                $imageBase64 = base64_encode(file_get_contents($imageFullPath));
                $mimeType = mime_content_type($imageFullPath);

                $messageData['content'][] = [
                    'type' => 'image_url',
                    'image_url' => [
                        'url' => "data:$mimeType;base64,$imageBase64"
                    ]
                ];
            } catch (\Exception $e) {
                $this->addError('image', 'Gagal upload gambar: ' . $e->getMessage());
                return;
            }
        }

        $this->messages[] = $messageData;

        // Clear form inputs
        $this->prompt = '';
        $this->image = null;
        $this->imagePreview = null;
        $this->isStreaming = true;

        $this->dispatch('start-streaming', 
            messages: $this->prepareMessagesForAPI()
        );
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:10240',
        ]);

        if ($this->image) {
            $this->imagePreview = $this->image->temporaryUrl();
        }
    }

    public function removeImage()
    {
        $this->image = null;
        $this->imagePreview = null;
    }

    protected function prepareMessagesForAPI(): array
    {
        $systemPrompt = config('app.llm_model.global_system_prompt') ?: 'Kamu adalah asisten nutrisi HealthGrade. Jawab dengan ramah dan informatif dalam Bahasa Indonesia.';
        
        $apiMessages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        foreach ($this->messages as $msg) {
            if (is_array($msg['content'])) {
                $hasImage = collect($msg['content'])->contains('type', 'image_url');
                
                if ($hasImage) {
                    $apiMessages[] = $msg;
                } else {
                    $textContent = collect($msg['content'])
                        ->where('type', 'text')
                        ->pluck('text')
                        ->implode(' ');
                    
                    $apiMessages[] = [
                        'role' => $msg['role'],
                        'content' => $textContent
                    ];
                }
            } else {
                $apiMessages[] = $msg;
            }
        }

        return $apiMessages;
    }

    #[On('streaming-complete')]
    public function onStreamingComplete(string $content)
    {
        // Clean up whitespace from streamed content
        $content = trim($content);
        
        // Get last user message text
        $lastUserMessage = collect($this->messages)
            ->where('role', 'user')
            ->last();
        
        $userPrompt = is_array($lastUserMessage['content'] ?? null) 
            ? collect($lastUserMessage['content'])->where('type', 'text')->pluck('text')->first()
            : ($lastUserMessage['content'] ?? '');

        // Save to database
        AiAssistant::create([
            'user_id' => Auth::id(),
            'food_id' => null,
            'user_prompt' => $userPrompt,
            'ai_response' => $content,
            'context_data' => null 
        ]);

        $this->messages[] = [
            'role' => 'assistant',
            'content' => $content,
        ];
        $this->isStreaming = false;
    }

    #[On('streaming-error')]
    public function onStreamingError(string $error)
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => 'Error: ' . $error,
        ];
        $this->isStreaming = false;
    }

    public function clearChat()
    {
        // Delete from database
        AiAssistant::where('user_id', Auth::id())
            ->whereNull('food_id')
            ->delete();

        $this->messages = [];
        $this->isStreaming = false;
        $this->image = null;
        $this->imagePreview = null;
    }

    public function render()
    {
        return view('livewire.ai-consultation');
    }
}