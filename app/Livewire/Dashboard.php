<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\ScanHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

#[Title('Dashboard - HealthGrade')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $userId = $user->id;
        $today = Carbon::today()->format('Y-m-d');

        // Cache dashboard stats for 5 minutes
        $stats = Cache::remember("dashboard_stats:{$userId}:{$today}", now()->addMinutes(5), function () use ($user) {
            return $this->calculateStats($user);
        });

        // Cache recent scans for 2 minutes
        $recentScans = Cache::remember("recent_scans:{$userId}", now()->addMinutes(2), function () use ($userId) {
            return ScanHistory::with('food')
                ->where('user_id', $userId)
                ->latest()
                ->take(4)
                ->get();
        });

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentScans' => $recentScans
        ]);
    }

    protected function calculateStats($user): array
    {
        // 1. Validasi Profil Dasar (Fallback jika belum diisi)
        $weight = $user->berat_badan ?? 60;
        $height = $user->tinggi_badan ?? 165;
        $age = $user->age ?? 25;
        $gender = $user->gender ?? 'male';

        // 2. Hitung BMR & TDEE (Rumus Mifflin-St Jeor)
        $baseBmr = (10 * $weight) + (6.25 * $height) - (5 * $age);
        $bmr = ($gender === 'male') ? $baseBmr + 5 : $baseBmr - 161;

        // Faktor Aktivitas
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
            ->where('action_type', 'consumed')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Agregasi Nutrisi
        $currentCalories = $todayHistories->sum('total_calories_intaken');
        
        $sugarConsumed = $todayHistories->sum(function($h) {
            $servingG = $h->food->serving_size_g ?? 100;
            return ($h->food->sugar_g / 100) * $servingG * $h->quantity;
        });
        
        $fatConsumed = $todayHistories->sum(function($h) {
            $servingG = $h->food->serving_size_g ?? 100;
            return ($h->food->fat_total_g / 100) * $servingG * $h->quantity;
        });
        
        $saltConsumed = $todayHistories->sum(function($h) {
            $servingG = $h->food->serving_size_g ?? 100;
            return ($h->food->salt_mg / 100) * $servingG * $h->quantity;
        });

        return [
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
    }
}