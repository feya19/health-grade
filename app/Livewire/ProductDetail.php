<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Http;

#[Title('Detail Produk - HealthGrade')]
class ProductDetail extends Component
{
    public $barcode;
    public $productData = null;
    public $loading = true;
    public $error = null;

    public function mount($barcode)
    {
        $this->barcode = $barcode;
        $this->loadProduct();
    }

    public function loadProduct()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Cek dari session flash terlebih dahulu
            if (session()->has('product_data')) {
                $this->productData = session('product_data');
                $this->loading = false;
                return;
            }

            // Jika tidak ada di session, ambil dari API
            $response = Http::get(url("/api/products/{$this->barcode}"));

            if ($response->successful()) {
                $this->productData = $response->json();
            } else {
                $this->error = 'Produk tidak ditemukan.';
            }
        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage();
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
