<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\AiAssistant;
use Illuminate\Support\Facades\Auth;

#[Title('HealthGrade Assistant')]
class AiConsultation extends Component
{
    public $prompt = '';
    public $chatHistory = [];

    public function mount()
    {
        $this->loadHistory();
    }

    public function loadHistory()
    {
        // Ambil 50 chat terakhir, urutkan dari terlama ke terbaru
        $this->chatHistory = AiAssistant::where('user_id', Auth::id())
            ->whereNull('food_id') // Filter chat general (bukan spesifik produk)
            ->latest()
            ->take(50)
            ->get()
            ->sortBy('id');
    }

    public function sendMessage()
    {
        $this->validate([
            'prompt' => 'required|string|min:2|max:500'
        ]);

        // 1. Simpan Prompt User
        // Kita butuh response dulu sebelum save ke DB agar satu row (sesuai struktur tabel Anda)
        // Atau: Create row baru.
        
        $userQuestion = $this->prompt;
        $this->prompt = ''; // Reset input segera agar UI responsif

        // 2. Simulasi "Thinking" AI (Logic Mockup)
        // Nanti ganti bagian ini dengan API Call (OpenAI / Gemini)
        $aiAnswer = $this->generateMockResponse($userQuestion);

        // 3. Simpan ke Database
        AiAssistant::create([
            'user_id' => Auth::id(),
            'food_id' => null, // Null karena ini konsultasi umum
            'user_prompt' => $userQuestion,
            'ai_response' => $aiAnswer,
            'context_data' => null 
        ]);

        // 4. Refresh Chat
        $this->loadHistory();
    }

    // --- LOGIC PURA-PURA AI (Hapus function ini jika sudah connect API Asli) ---
    private function generateMockResponse($question)
    {
        $q = strtolower($question);
        
        if (str_contains($q, 'diet')) {
            return "Untuk diet sehat, pastikan defisit kalori sekitar 300-500 kkal dari TDEE harianmu. Perbanyak protein dan serat, serta kurangi gula tambahan.";
        }
        if (str_contains($q, 'air') || str_contains($q, 'minum')) {
            return "Kebutuhan cairan rata-rata adalah 30-35ml per kg berat badan. Jangan lupa minum lebih banyak jika berolahraga!";
        }
        if (str_contains($q, 'gula')) {
            return "Batas konsumsi gula harian yang disarankan Kemenkes adalah 50 gram (setara 4 sendok makan). Cek label makananmu dengan fitur Scan kami!";
        }
        if (str_contains($q, 'halo') || str_contains($q, 'hi')) {
            return "Halo! Saya asisten kesehatan HealthGrade. Ada yang bisa saya bantu mengenai nutrisi hari ini?";
        }

        return "Pertanyaan yang bagus! Secara umum, menjaga pola makan seimbang (Gizi Seimbang) adalah kunci kesehatan jangka panjang. Ada lagi yang ingin ditanyakan?";
    }

    public function render()
    {
        return view('livewire.ai-consultation');
    }
}