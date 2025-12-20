<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Test (Bisa login pakai ini)
        User::create([
            'name' => 'Pengguna Test',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // password login: password
            'gender' => 'male',
            'berat_badan' => 70.5,
            'tinggi_badan' => 175.0,
            'date_of_birth' => '1998-05-20',
        ]);

        // 2. Akun Dummy Lainnya
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'gender' => 'female',
            'berat_badan' => 55.0,
            'tinggi_badan' => 160.0,
            'date_of_birth' => '2000-01-15',
        ]);
    }
}