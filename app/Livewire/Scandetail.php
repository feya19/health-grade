<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Produk - HealthGrade')]
class ScanDetail extends Component
{
    public $product;

    public function mount($id)
    {
        // MOCK DATA SINGLE PRODUCT
        // Di aplikasi nyata: $this->product = Product::findOrFail($id);
        $this->product = [
            'id' => $id,
            'name' => 'Keripik Kentang Asin',
            'brand' => 'Indofood',
            'barcode' => '899990909090',
            'grade' => 'D',
            'image' => null, // null = pakai placeholder
            'date_scanned' => '10 Okt 2025, 14:30',
            
            // Nutrisi per sajian
            'nutrition' => [
                'calories' => 250,
                'sugar' => 12,    // gram (Tinggi)
                'salt' => 450,    // mg (Tinggi)
                'fat' => 15,      // gram (Tinggi)
                'protein' => 2,
            ],

            // Analisis AI (Simulasi response LLM)
            'ai_analysis' => "Produk ini masuk dalam kategori **Grade D** karena kandungan garam dan lemak jenuhnya yang sangat tinggi. Konsumsi berlebihan dapat meningkatkan risiko hipertensi. Sebaiknya batasi konsumsi maksimal 1 bungkus per minggu atau cari alternatif keripik panggang."
        ];
    }

    public function delete()
    {
        // Logic hapus
        return $this->redirect(route('history'), navigate: true);
    }

    public function render()
    {
        return view('livewire.scan-detail');
    }
}