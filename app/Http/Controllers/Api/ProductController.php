<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenFoodFactsService;

class ProductController extends Controller
{
    public function __construct(
        protected OpenFoodFactsService $openFoodFacts
    ) {}

    private function getGrade(string $type, ?float $value): ?string
    {
        if ($value === null || $value === 0) {
            return null;
        }

        $grades = config("app.health_grades.{$type}", []);

        foreach ($grades as $grade => $range) {
            [$min, $max] = $range;

            if ($max === null) {
                if ($value >= $min) {
                    return $grade;
                }
            } else {
                if ($value >= $min && $value <= $max) {
                    return $grade;
                }
            }
        }

        return null;
    }

    private function getFinalGrade(?string $sugarGrade, ?string $fatGrade): ?string
    {
        // Jika salah satu tidak ada, return yang ada
        if (!$sugarGrade) return $fatGrade;
        if (!$fatGrade) return $sugarGrade;

        $gradeOrder = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];

        $sugarLevel = $gradeOrder[$sugarGrade] ?? 0;
        $fatLevel = $gradeOrder[$fatGrade] ?? 0;

        // Jika fat lebih buruk (level lebih tinggi), sugar ikut turun ke grade fat
        if ($fatLevel > $sugarLevel) {
            return $fatGrade;
        }

        // Jika fat lebih baik atau sama, ikuti sugar
        return $sugarGrade;
    }

    public function show(string $barcode)
    {
        $data = $this->openFoodFacts->getProduct($barcode);

        if (($data['status'] ?? 0) !== 1) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product = $data['product'];

        $sugars = $product['nutriments']['sugars_100g'] ?? null;
        $saturatedFat = $product['nutriments']['saturated-fat_100g'] ?? null;

        // Get individual grades
        $sugarGrade = $this->getGrade('sugar', $sugars);
        $fatGrade = $this->getGrade('saturated_fat', $saturatedFat);

        // Get final grade
        $finalGrade = $this->getFinalGrade($sugarGrade, $fatGrade);

        return response()->json([
            'barcode' => $data['code'] ?? $barcode,
            'product_name' => $product['product_name'] ?? null,
            'brands' => $product['brands'] ?? null,
            'image' => $product['image_url'] ?? null,
            'nutrition' => [
                'energy_kcal_100g' => $product['nutriments']['energy-kcal_100g'] ?? null,
                'fat_100g' => $product['nutriments']['fat_100g'] ?? null,
                'saturated_fat_100g' => $saturatedFat,
                'carbohydrates_100g' => $product['nutriments']['carbohydrates_100g'] ?? null,
                'sugars_100g' => $sugars,
                'fiber_100g' => $product['nutriments']['fiber_100g'] ?? null,
                'proteins_100g' => $product['nutriments']['proteins_100g'] ?? null,
                'salt_100g' => $product['nutriments']['salt_100g'] ?? null,
                'sodium_100g' => $product['nutriments']['sodium_100g'] ?? null,
            ],
            'health_grade' => [
                'sugar_grade' => $sugarGrade,   
                'saturated_fat_grade' => $fatGrade,
                'final_grade' => $finalGrade,
            ],
            'nutriscore_grade' => $product['nutriscore_grade'] ?? null,
        ]);
    }
}
