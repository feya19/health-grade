<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan penting! Food & User harus duluan sebelum ScanHistory
        $this->call([
            UserSeeder::class,
            FoodSeeder::class,
            ScanHistorySeeder::class,
            AiAssistantSeeder::class,
        ]);
    }
}
