<?php

namespace Database\Seeders;

use App\Models\AiAssistant;
use App\Models\User;
use App\Models\Food;
use Illuminate\Database\Seeder;

class AiAssistantSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $indomie = Food::where('name', 'like', '%Indomie%')->first();

        if ($user && $indomie) {
            AiAssistant::create([
                'user_id' => $user->id,
                'food_id' => $indomie->id,
                'user_prompt' => 'Apakah mie goreng ini aman dikonsumsi saat diet?',
                'ai_response' => 'Indomie Goreng memiliki kalori 380kkal dan natrium sangat tinggi (1070mg). Jika tujuan dietmu adalah defisit kalori dan mengurangi retensi air, sebaiknya batasi konsumsi produk ini atau ganti dengan opsi Grade A/B.',
                'context_data' => json_encode([
                    'food_name' => $indomie->name,
                    'nutrition' => [
                        'calories' => $indomie->calories,
                        'salt' => $indomie->salt_mg
                    ]
                ]),
                'created_at' => now()->subDays(2),
            ]);
        }
        
        // Chat general tanpa konteks makanan spesifik
        AiAssistant::create([
            'user_id' => $user->id,
            'food_id' => null,
            'user_prompt' => 'Berapa kebutuhan air putih harian saya?',
            'ai_response' => 'Berdasarkan berat badanmu 70.5kg, disarankan minum sekitar 2.1 - 2.5 liter air per hari.',
            'context_data' => null,
            'created_at' => now()->subHours(5),
        ]);
    }
}