<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\AiAssistant;
use App\Models\ScanHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $user = Auth::user();
        
        // Build personalized system prompt with user data
        $basePrompt = config('app.llm_model.global_system_prompt') ?: 'Kamu adalah asisten nutrisi HealthGrade. Jawab dengan ramah dan informatif dalam Bahasa Indonesia.';
        
        // Add user profile context if available
        $userContext = $this->buildUserContext($user);
        $consumptionContext = $this->buildConsumptionContext($user);
        $systemPrompt = $basePrompt . $userContext . $consumptionContext;
        
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
    
    protected function buildUserContext($user): string
    {
        $context = [];
        
        // Gender
        if ($user->gender) {
            $genderText = $user->gender === 'male' ? 'laki-laki' : 'perempuan';
            $context[] = "Jenis kelamin: {$genderText}";
        }
        
        // Age
        if ($user->age) {
            $context[] = "Usia: {$user->age} tahun";
        }
        
        // Weight (berat_badan)
        if ($user->berat_badan) {
            $context[] = "Berat badan: {$user->berat_badan} kg";
        }
        
        // Height (tinggi_badan)
        if ($user->tinggi_badan) {
            $context[] = "Tinggi badan: {$user->tinggi_badan} cm";
        }
        
        // Calculate BMI if both weight and height available
        if ($user->berat_badan && $user->tinggi_badan) {
            $heightM = $user->tinggi_badan / 100;
            $bmi = round($user->berat_badan / ($heightM * $heightM), 1);
            $bmiCategory = match(true) {
                $bmi < 18.5 => 'Kurus',
                $bmi < 25 => 'Normal',
                $bmi < 30 => 'Overweight',
                default => 'Obesitas'
            };
            $context[] = "BMI: {$bmi} ({$bmiCategory})";
        }
        
        if (empty($context)) {
            return '';
        }
        
        return "\n\n[PROFIL PENGGUNA - Gunakan informasi ini untuk memberikan saran yang lebih personal]\n" . implode("\n", $context);
    }

    protected function buildConsumptionContext($user): string
    {
        // Cache consumption context for 5 minutes per user per day
        $cacheKey = "consumption_context:{$user->id}:" . Carbon::today()->format('Y-m-d');
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            return $this->buildConsumptionContextData($user);
        });
    }

    protected function buildConsumptionContextData($user): string
    {
        // Get today's consumption data
        $todayHistories = ScanHistory::with('food')
            ->where('user_id', $user->id)
            ->where('action_type', 'consumed')
            ->whereDate('created_at', Carbon::today())
            ->get();

        if ($todayHistories->isEmpty()) {
            return "\n\n[KONSUMSI HARI INI - " . Carbon::today()->format('d M Y') . "]\nBelum ada makanan yang dikonsumsi hari ini.";
        }

        // Calculate daily calorie target (same logic as Dashboard)
        $weight = $user->berat_badan ?? 60;
        $height = $user->tinggi_badan ?? 165;
        $age = $user->age ?? 25;
        $gender = $user->gender ?? 'male';

        $baseBmr = (10 * $weight) + (6.25 * $height) - (5 * $age);
        $bmr = ($gender === 'male') ? $baseBmr + 5 : $baseBmr - 161;
        $dailyCalorieTarget = round($bmr * 1.2); // Sedentary activity level

        // Calculate totals
        $currentCalories = $todayHistories->sum('total_calories_intaken');
        
        $sugarConsumed = $todayHistories->sum(function($h) {
            $servingG = $h->food->serving_size_g ?? 100;
            return ($h->food->sugar_g / 100) * $servingG * $h->quantity;
        });
        
        $fatConsumed = $todayHistories->sum(function($h) {
            $servingG = $h->food->serving_size_g ?? 100;
            return ($h->food->fat_total_g / 100) * $servingG * $h->quantity;
        });
        
        $saltConsumed = $todayHistories->sum(function($h) {
            $servingG = $h->food->serving_size_g ?? 100;
            return ($h->food->salt_mg / 100) * $servingG * $h->quantity;
        });

        // Build food list
        $foodList = [];
        foreach ($todayHistories as $index => $history) {
            $food = $history->food;
            $foodList[] = ($index + 1) . ". {$food->name}" . 
                ($food->brand ? " ({$food->brand})" : "") . 
                " - {$history->quantity} porsi, " . 
                round($history->total_calories_intaken) . " kkal";
        }

        // Calculate percentages
        $caloriePercent = $dailyCalorieTarget > 0 ? round(($currentCalories / $dailyCalorieTarget) * 100) : 0;
        $sugarPercent = round(($sugarConsumed / 50) * 100);
        $saltPercent = round(($saltConsumed / 2000) * 100);
        $fatPercent = round(($fatConsumed / 67) * 100);

        // Determine status
        $status = match(true) {
            $caloriePercent > 100 => 'Kalori sudah melebihi target harian!',
            $caloriePercent >= 80 => 'Sudah mendekati target kalori harian.',
            $caloriePercent >= 50 => 'Asupan kalori dalam kondisi baik.',
            default => 'Masih banyak ruang untuk asupan kalori.'
        };

        $warnings = [];
        if ($sugarPercent > 100) $warnings[] = 'Gula sudah melebihi batas harian!';
        if ($saltPercent > 100) $warnings[] = 'Garam sudah melebihi batas harian!';
        if ($fatPercent > 100) $warnings[] = 'Lemak sudah melebihi batas harian!';

        $context = "\n\n[KONSUMSI HARI INI - " . Carbon::today()->format('d M Y') . "]";
        $context .= "\nMakanan yang sudah dikonsumsi:";
        $context .= "\n" . implode("\n", $foodList);
        $context .= "\n\nTotal Nutrisi:";
        $context .= "\n- Kalori: " . round($currentCalories) . "/{$dailyCalorieTarget} kkal ({$caloriePercent}%)";
        $context .= "\n- Gula: " . round($sugarConsumed, 1) . "g / 50g ({$sugarPercent}%)";
        $context .= "\n- Garam: " . round($saltConsumed) . "mg / 2000mg ({$saltPercent}%)";
        $context .= "\n- Lemak: " . round($fatConsumed, 1) . "g / 67g ({$fatPercent}%)";
        $context .= "\n\nStatus: {$status}";
        
        if (!empty($warnings)) {
            $context .= "\nPeringatan: " . implode(", ", $warnings);
        }

        $context .= "\n\n[INSTRUKSI: Hanya gunakan data diatas ketika menjawab pertanyaan tentang konsumsi atau makanan, hanya ketika ada konteks 'hari ini' atau tanggal (" . Carbon::today()->format('d M Y') . ") agar user tahu data yang dibahas adalah data terkini. Gunakan data konsumsi di atas untuk menjawab pertanyaan tentang apa yang sudah dimakan hari ini, rekap harian, atau memberikan saran nutrisi yang relevan berdasarkan asupan hari ini.]";

        return $context;
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