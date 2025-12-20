<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Food;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\Auth;

#[Title('Scan Barcode - HealthGrade')]
class ScanBarcode extends Component
{
    public $error = null;

    public function handleScan($decodedText)
    {
        // 1. Cari di Database Lokal
        $food = Food::where('barcode', $decodedText)->first();

        // 2. Jika Tidak Ada, Panggil API FatSecret (Placeholder Logic)
        if (!$food) {
            // TODO: Integrasi FatSecret API di sini
            // $apiData = FatSecret::get($decodedText);
            // $food = Food::create([...mapping data API...]);
            
            // Sementara return error jika tidak ada di DB seed
            $this->addError('scan', 'Produk tidak ditemukan di database. Coba scan produk dummy (Ex: Indomie: 8998866200578)');
            return;
        }

        // 3. Jika Ada, Catat History sebagai 'scan_only' (belum dimakan)
        ScanHistory::create([
            'user_id' => Auth::id(),
            'food_id' => $food->id,
            'quantity' => 1,
            'total_calories_intaken' => 0, // 0 karena belum dikonsumsi
            'action_type' => 'scan_only'
        ]);

        session()->flash('success', 'Produk ditemukan: ' . $food->name);

        // 4. Redirect ke Detail menggunakan ID FOOD
        return $this->redirect(route('scan.detail', ['id' => $food->id]), navigate: true);
    }

    public function render()
    {
        return view('livewire.scan-barcode');
    }
}