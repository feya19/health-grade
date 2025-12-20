<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Riwayat Scan - HealthGrade')]
class History extends Component
{
    use WithPagination;

    public $search = '';
    public $filterGrade = 'all';

    public function render()
    {
        // MOCK DATA (Nanti ganti dengan: Product::where('user_id', auth()->id())...)
        $allHistory = collect([
            ['id' => 1, 'name' => 'Keripik Kentang Asin', 'grade' => 'D', 'date' => '10 Okt 2025', 'calories' => 250, 'img' => 'kp.jpg'],
            ['id' => 2, 'name' => 'Yoghurt Low Fat', 'grade' => 'A', 'date' => '10 Okt 2025', 'calories' => 80, 'img' => 'yg.jpg'],
            ['id' => 3, 'name' => 'Biskuit Coklat', 'grade' => 'C', 'date' => '09 Okt 2025', 'calories' => 120, 'img' => 'bc.jpg'],
            ['id' => 4, 'name' => 'Sari Gandum', 'grade' => 'B', 'date' => '09 Okt 2025', 'calories' => 95, 'img' => 'sg.jpg'],
            ['id' => 5, 'name' => 'Minuman Soda', 'grade' => 'D', 'date' => '08 Okt 2025', 'calories' => 140, 'img' => 'ms.jpg'],
            ['id' => 6, 'name' => 'Salad Buah', 'grade' => 'A', 'date' => '08 Okt 2025', 'calories' => 110, 'img' => 'sb.jpg'],
        ]);

        // Logic Filter & Search Sederhana (Mockup)
        $history = $allHistory->filter(function ($item) {
            $matchesSearch = stripos($item['name'], $this->search) !== false;
            $matchesGrade = $this->filterGrade === 'all' || $item['grade'] === $this->filterGrade;
            return $matchesSearch && $matchesGrade;
        });

        return view('livewire.history', [
            'history' => $history
        ]);
    }
}