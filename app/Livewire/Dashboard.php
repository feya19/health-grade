<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard - HealthGrade')]
class Dashboard extends Component
{
    public function render()
    {
        // 1. Ambil Data User (Ganti nilai ini dengan field database asli Anda nanti)
        $userProfile = [
            'gender' => 'female', // 'male' atau 'female'
            'weight' => 60,       // kg
            'height' => 165,      // cm
            'age'    => 22        // tahun
        ];

        // 2. Hitung BMR (Rumus Harris-Benedict)
        if ($userProfile['gender'] === 'male') {
            // Rumus Pria: 66 + (13.7 x BB) + (5 x TB) – (6.8 x Umur)
            $bmr = 66 + (13.7 * $userProfile['weight']) + (5 * $userProfile['height']) - (6.8 * $userProfile['age']);
        } else {
            // Rumus Wanita: 655 + (9.6 x BB) + (1.8 x TB) – (4.7 x Umur)
            $bmr = 655 + (9.6 * $userProfile['weight']) + (1.8 * $userProfile['height']) - (4.7 * $userProfile['age']);
        }

        // Bulatkan hasil BMR
        $dailyCalorieTarget = round($bmr);
        
        // Data Konsumsi Kalori Hari Ini (Mockup)
        $currentCalories = 1250; 

        // 3. Masukkan ke array stats yang sudah ada
        $stats = [
            'gula_consumed' => 18,
            'gula_limit' => 50,
            'lemak_consumed' => 12,
            'lemak_limit' => 67,
            'total_scan' => 45,
            // Tambahkan data kalori baru
            'calories_current' => $currentCalories,
            'calories_target' => $dailyCalorieTarget,
            'user_weight' => $userProfile['weight'], // Untuk display
            'user_height' => $userProfile['height'], // Untuk display
        ];

        // Data Recent Scans (Tetap sama)
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