<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;

#[Title('Scan Barcode - HealthGrade')]
class ScanBarcode extends Component
{
    public $lastResult = null;
    public $error = null;
    public $productData = null;

    // Method ini akan dipanggil oleh JavaScript saat barcode terdeteksi
    public function handleScan($decodedText)
    {
        $this->lastResult = $decodedText;
        $this->error = null;

        try {
            // Panggil API internal product
            $response = Http::get(url("/api/products/{$decodedText}"));

            if ($response->successful()) {
                $this->productData = $response->json();

                // Redirect ke halaman detail dengan data produk
                session()->flash('product_data', $this->productData);
                session()->flash('success', 'Produk berhasil ditemukan!');

                return $this->redirect(route('product.detail', ['barcode' => $decodedText]), navigate: true);
            } else {
                $this->error = 'Produk tidak ditemukan dalam database.';
                session()->flash('error', $this->error);
            }
        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage();
            session()->flash('error', $this->error);
        }
    }

    public function render()
    {
        return view('livewire.scan-barcode');
    }
}
