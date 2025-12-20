<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard - HealthGrade')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'gula_consumed' => 18,
            'gula_limit' => 50,
            'lemak_consumed' => 12,
            'lemak_limit' => 67,
            'total_scan' => 45,
            'health_score' => 82
        ];

        $recentScans = [
            (object)['name' => 'Keripik Kentang Asin', 'grade' => 'D', 'date' => 'Hari ini, 10:00', 'calories' => '250 kkal'],
            (object)['name' => 'Yoghurt Low Fat', 'grade' => 'A', 'date' => 'Hari ini, 08:30', 'calories' => '80 kkal'],
            (object)['name' => 'Biskuit Coklat', 'grade' => 'C', 'date' => 'Kemarin, 19:20', 'calories' => '120 kkal'],
            (object)['name' => 'Sari Gandum', 'grade' => 'B', 'date' => 'Kemarin, 14:00', 'calories' => '95 kkal'],
        ];

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentScans' => $recentScans
        ]);
    }
}