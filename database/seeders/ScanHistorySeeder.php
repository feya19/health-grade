<?php

namespace Database\Seeders;

use App\Models\ScanHistory;
use App\Models\User;
use App\Models\Food;
use Illuminate\Database\Seeder;

class ScanHistorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        
        // Ambil beberapa makanan dari database
        $indomie = Food::where('name', 'like', '%Indomie%')->first();
        $milk = Food::where('name', 'like', '%Ultra Milk%')->first();
        $oats = Food::where('name', 'like', '%Quaker%')->first();

        // Skenario 1: User scan Indomie tapi tidak makan (Cuma cek)
        if ($indomie) {
            ScanHistory::create([
                'user_id' => $user->id,
                'food_id' => $indomie->id,
                'quantity' => 1,
                'total_calories_intaken' => 0, // 0 karena tidak dimakan
                'action_type' => 'scan_only',
                'created_at' => now()->subDays(2),
            ]);
        }

        // Skenario 2: User minum susu kemarin
        if ($milk) {
            ScanHistory::create([
                'user_id' => $user->id,
                'food_id' => $milk->id,
                'quantity' => 1,
                'total_calories_intaken' => $milk->calories, // Masuk hitungan
                'action_type' => 'consumed',
                'created_at' => now()->subDay(),
            ]);
        }

        // Skenario 3: User makan Oatmeal hari ini (2 porsi)
        if ($oats) {
            ScanHistory::create([
                'user_id' => $user->id,
                'food_id' => $oats->id,
                'quantity' => 2,
                'total_calories_intaken' => $oats->calories * 2,
                'action_type' => 'consumed',
                'created_at' => now(),
            ]);
        }
    }
}