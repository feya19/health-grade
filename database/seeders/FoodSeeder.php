<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            [
                'barcode' => '8998866200578', // Indomie Goreng
                'name' => 'Indomie Mi Goreng',
                'brand' => 'Indofood',
                'serving_size' => '85g',
                'calories' => 380,
                'sugar_g' => 5,
                'salt_mg' => 1070, // Sangat tinggi garam
                'fat_total_g' => 14,
                'fat_saturated_g' => 6,
                'protein_g' => 8,
                'carbo_g' => 54,
                'cholesterol_mg' => 0,
                'grade' => 'D',
                'nutri_score_details' => json_encode(['points' => 18, 'notes' => 'Tinggi Garam & Lemak Jenuh']),
                'image_url' => 'https://assets.klikindomaret.com/products/10003518/10003518_1.jpg',
            ],
            [
                'barcode' => '8991002104128', // Ultra Milk Coklat
                'name' => 'Ultra Milk Coklat 250ml',
                'brand' => 'Ultrajaya',
                'serving_size' => '250ml',
                'calories' => 170,
                'sugar_g' => 18, // Tinggi gula
                'salt_mg' => 105,
                'fat_total_g' => 4,
                'fat_saturated_g' => 2.5,
                'protein_g' => 8,
                'carbo_g' => 26,
                'cholesterol_mg' => 5,
                'grade' => 'C',
                'nutri_score_details' => json_encode(['points' => 12, 'notes' => 'Tinggi Gula']),
                'image_url' => 'https://assets.klikindomaret.com/products/20002625/20002625_1.jpg',
            ],
            [
                'barcode' => '0000000000001', // Quaker Oats (Contoh Sehat)
                'name' => 'Quaker Oats Instant',
                'brand' => 'Quaker',
                'serving_size' => '35g',
                'calories' => 130,
                'sugar_g' => 1,
                'salt_mg' => 0,
                'fat_total_g' => 2.5,
                'fat_saturated_g' => 0.5,
                'protein_g' => 3,
                'carbo_g' => 24,
                'cholesterol_mg' => 0,
                'grade' => 'A',
                'nutri_score_details' => json_encode(['points' => -2, 'notes' => 'Kaya Serat, Rendah GGL']),
                'image_url' => null,
            ],
            [
                'barcode' => '8886008101053', // Coca Cola
                'name' => 'Coca Cola PET 390ml',
                'brand' => 'Coca Cola',
                'serving_size' => '390ml',
                'calories' => 164,
                'sugar_g' => 41, // Sangat tinggi gula
                'salt_mg' => 45,
                'fat_total_g' => 0,
                'fat_saturated_g' => 0,
                'protein_g' => 0,
                'carbo_g' => 41,
                'cholesterol_mg' => 0,
                'grade' => 'D',
                'nutri_score_details' => json_encode(['points' => 22, 'notes' => 'Sangat Tinggi Gula']),
                'image_url' => null,
            ],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}