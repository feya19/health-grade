<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Scan Barcode - HealthGrade')]
class ScanBarcode extends Component
{
    public $lastResult = null;
    public $error = null;

    // Method ini akan dipanggil oleh JavaScript saat barcode terdeteksi
    public function handleScan($decodedText)
    {
        // 1. Cek di Database (Mockup logic)
        // Di real app: $product = Product::where('barcode', $decodedText)->first();
        
        // Simulasi jika produk ditemukan atau tidak
        $this->lastResult = $decodedText;

        // Contoh: Jika barcode '12345', kita anggap produk ada dan redirect ke detail
        // Jika tidak, kita bisa tampilkan pesan error atau form tambah produk
        
        // Simulasi Redirect ke halaman Detail (ID 1 sebagai contoh)
        session()->flash('success', 'Barcode berhasil dipindai: ' . $decodedText);
        
        // Redirect ke detail dummy (Ganti ID sesuai hasil DB nanti)
        return $this->redirect(route('scan.detail', ['id' => 1]), navigate: true);
    }

    public function render()
    {
        return view('livewire.scan-barcode');
    }
}