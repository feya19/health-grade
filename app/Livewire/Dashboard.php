<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\ScanHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

#[Title('Dashboard - HealthGrade')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        // 1. Validasi Profil Dasar (Fallback jika belum diisi)
        $weight = $user->weight ?? 60;
        $height = $user->height ?? 165;
        $age = $user->age ?? 25; // Menggunakan accessor getAgeAttribute() dari Model User
        $gender = $user->gender ?? 'male';

        // 2. Hitung BMR & TDEE (Rumus Mifflin-St Jeor)
        // Pria: (10 x BB) + (6.25 x TB) - (5 x Usia) + 5
        // Wanita: (10 x BB) + (6.25 x TB) - (5 x Usia) - 161
        $baseBmr = (10 * $weight) + (6.25 * $height) - (5 * $age);
        $bmr = ($gender === 'male') ? $baseBmr + 5 : $baseBmr - 161;

        // Faktor Aktivitas (Sederhana)
        $activityMultipliers = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'extreme' => 1.9,
        ];
        
        $activityLevel = $user->activity_level ?? 'sedentary';
        $dailyCalorieTarget = round($bmr * ($activityMultipliers[$activityLevel] ?? 1.2));

        // 3. Ambil Data Konsumsi HARI INI dari Database
        $todayHistories = ScanHistory::with('food')
            ->where('user_id', $user->id)
            ->where('action_type', 'consumed') // Hanya yang dimakan
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Agregasi Nutrisi
        $currentCalories = $todayHistories->sum('total_calories_intaken');
        
        // Hitung total GGL (Gula Garam Lemak) manual dari relasi food * quantity
        $sugarConsumed = $todayHistories->sum(fn($h) => $h->food->sugar_g * $h->quantity);
        $fatConsumed = $todayHistories->sum(fn($h) => $h->food->fat_total_g * $h->quantity);
        $saltConsumed = $todayHistories->sum(fn($h) => $h->food->salt_mg * $h->quantity);

        // Batas Harian (Hardcoded standar Kemenkes/WHO untuk umum)
        // Gula: 50g, Garam: 2000mg, Lemak: 67g
        $stats = [
            'gula_consumed' => $sugarConsumed,
            'gula_limit' => 50,
            'garam_consumed' => $saltConsumed,
            'garam_limit' => 2000, 
            'lemak_consumed' => $fatConsumed,
            'lemak_limit' => 67,
            'total_scan' => ScanHistory::where('user_id', $user->id)->count(),
            'calories_current' => $currentCalories,
            'calories_target' => $dailyCalorieTarget,
            'user_weight' => $weight,
            'user_height' => $height,
        ];

        // 4. Data Recent Scans (Ambil 4 terakhir dari DB)
        $recentScans = ScanHistory::with('food')
            ->where('user_id', $user->id)
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentScans' => $recentScans
        ]);
    }
}