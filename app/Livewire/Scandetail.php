<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Food;
use App\Models\ScanHistory;
use App\Models\AiAssistant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

#[Title('Detail Produk - HealthGrade')]
class ScanDetail extends Component
{
    public Food $food; // Type hinting model
    public $quantity = 1;
    
    // Variabel Chat AI
    public $userPrompt = '';
    public $aiResponse = null;
    public $isChatting = false;

    public function mount($id)
    {
        // Cache food by ID for 1 hour
        $this->food = Cache::remember("food:id:{$id}", now()->addHour(), function () use ($id) {
            return Food::findOrFail($id);
        });
    }

    // Fitur: Catat Makan (Update history atau buat baru)
    public function consume()
    {
        ScanHistory::create([
            'user_id' => Auth::id(),
            'food_id' => $this->food->id,
            'quantity' => $this->quantity,
            'total_calories_intaken' => $this->food->calories * $this->quantity,
            'action_type' => 'consumed'
        ]);

        session()->flash('success', 'Berhasil dicatat ke asupan harian!');
        
        // Invalidate consumption context cache for this user
        $userId = Auth::id();
        $today = Carbon::today()->format('Y-m-d');
        Cache::forget("consumption_context:{$userId}:{$today}");
        Cache::forget("dashboard_stats:{$userId}:{$today}");
        Cache::forget("recent_scans:{$userId}");
        
        return $this->redirect(route('dashboard'), navigate: true);
    }

    // Fitur: Tanya AI
    public function askAi()
    {
        $this->validate(['userPrompt' => 'required|string|min:3']);
        $this->isChatting = true;

        // --- SIMULASI CALL LLM (Ganti dengan API Call asli nanti) ---
        // $response = OpenAi::ask("Konteks makanan: {$this->food->name}. Pertanyaan: {$this->userPrompt}");
        
        $dummyResponses = [
            'aman' => "Untuk {$this->food->name}, konsumsinya masih aman asalkan tidak melebihi 1 porsi karena kandungan gulanya.",
            'diet' => "Produk ini memiliki grade {$this->food->grade}. Jika sedang diet ketat, sebaiknya kurangi porsinya.",
            'default' => "Analisis nutrisi: Gula {$this->food->sugar_g}g, Garam {$this->food->salt_mg}mg. Harap bijak mengonsumsinya."
        ];
        
        $finalResponse = $dummyResponses['default']; // Fallback
        // ------------------------------------------------------------

        // Simpan ke Database
        AiAssistant::create([
            'user_id' => Auth::id(),
            'food_id' => $this->food->id,
            'user_prompt' => $this->userPrompt,
            'ai_response' => $finalResponse,
            'context_data' => [
                'nutrition' => $this->food->toArray(),
                'grade' => $this->food->grade
            ]
        ]);

        $this->aiResponse = $finalResponse;
        $this->userPrompt = ''; // Reset input
    }

    public function render()
    {
        // Ambil riwayat chat sebelumnya untuk makanan ini (Opsional)
        $chatHistory = AiAssistant::where('user_id', Auth::id())
            ->where('food_id', $this->food->id)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.scan-detail', [
            'chatHistory' => $chatHistory
        ]);
    }
}