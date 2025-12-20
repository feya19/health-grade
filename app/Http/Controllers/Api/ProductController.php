<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
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
        if (!$sugarGrade) return $fatGrade;
        if (!$fatGrade) return $sugarGrade;

        $gradeOrder = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];

        $sugarLevel = $gradeOrder[$sugarGrade] ?? 0;
        $fatLevel = $gradeOrder[$fatGrade] ?? 0;

        if ($fatLevel > $sugarLevel) {
            return $fatGrade;
        }

        return $sugarGrade;
    }

    /**
     * Format local Food model to API response
     */
    private function formatLocalProduct(Food $food): array
    {
        $sugarGrade = $this->getGrade('sugar', $food->sugar_g);
        $fatGrade = $this->getGrade('saturated_fat', $food->fat_saturated_g);
        $finalGrade = $this->getFinalGrade($sugarGrade, $fatGrade);

        return [
            'source' => 'local_db',
            'barcode' => $food->barcode,
            'product_name' => $food->name,
            'brands' => $food->brand,
            'image' => $food->image_url,
            'serving_size' => $food->serving_size,
            'serving_size_g' => $food->serving_size_g,
            'nutrition' => [
                'energy_kcal_100g' => $food->calories,
                'fat_100g' => $food->fat_total_g,
                'saturated_fat_100g' => $food->fat_saturated_g,
                'carbohydrates_100g' => $food->carbo_g,
                'sugars_100g' => $food->sugar_g,
                'proteins_100g' => $food->protein_g,
                'sodium_100g' => $food->salt_mg ? $food->salt_mg / 1000 : null,
            ],
            'health_grade' => [
                'sugar_grade' => $sugarGrade,
                'saturated_fat_grade' => $fatGrade,
                'final_grade' => $finalGrade ?? $food->grade,
            ],
        ];
    }

    /**
     * Cache OFF product to local database
     */
    private function cacheToLocalDb(string $barcode, array $product): Food
    {
        // OpenFoodFacts provides serving_size as string like "100g" or "250ml"
        $servingSizeStr = $product['serving_size'] ?? null;
        $servingSizeG = null;
        if ($servingSizeStr) {
            // Extract numeric value from serving size string
            preg_match('/([\d.]+)/', $servingSizeStr, $matches);
            $servingSizeG = isset($matches[1]) ? floatval($matches[1]) : null;
        }

        return Food::updateOrCreate(
            ['barcode' => $barcode],
            [
                'name' => $product['product_name'] ?? 'Unknown Product',
                'brand' => $product['brands'] ?? null,
                'image_url' => $product['image_url'] ?? $product['image_front_url'] ?? $product['image_front_small_url'] ?? null,
                'serving_size' => $servingSizeStr,
                'serving_size_g' => $servingSizeG,
                'calories' => $product['nutriments']['energy-kcal_100g'] ?? null,
                'sugar_g' => $product['nutriments']['sugars_100g'] ?? null,
                'salt_mg' => isset($product['nutriments']['sodium_100g']) 
                    ? $product['nutriments']['sodium_100g'] * 1000 
                    : null,
                'fat_total_g' => $product['nutriments']['fat_100g'] ?? null,
                'fat_saturated_g' => $product['nutriments']['saturated-fat_100g'] ?? null,
                'protein_g' => $product['nutriments']['proteins_100g'] ?? null,
                'carbo_g' => $product['nutriments']['carbohydrates_100g'] ?? null,
            ]
        );
    }

    public function show(string $barcode)
    {
        // ========================================
        // LAYER 1: Check Local Database (Fastest)
        // ========================================
        $localFood = Food::where('barcode', $barcode)->first();
        
        if ($localFood && $localFood->sugar_g !== null) {
            return response()->json($this->formatLocalProduct($localFood));
        }

        // ========================================
        // LAYER 2: Check Open Food Facts API
        // ========================================
        $data = $this->openFoodFacts->getProduct($barcode);

        if (($data['status'] ?? 0) === 1) {
            $product = $data['product'];
            $sugars = $product['nutriments']['sugars_100g'] ?? null;
            $saturatedFat = $product['nutriments']['saturated-fat_100g'] ?? null;
            $sodium = $product['nutriments']['sodium_100g'] ?? null;

            // Validate: all 3 key nutrition data must exist
            $hasValidNutrition = ($sugars !== null && $saturatedFat !== null && $sodium !== null);

            if ($hasValidNutrition) {
                // Cache to local DB for future scans
                $cached = $this->cacheToLocalDb($barcode, $product);

                $sugarGrade = $this->getGrade('sugar', $sugars);
                $fatGrade = $this->getGrade('saturated_fat', $saturatedFat);
                $finalGrade = $this->getFinalGrade($sugarGrade, $fatGrade);

                return response()->json([
                    'source' => 'openfoodfacts',
                    'barcode' => $data['code'] ?? $barcode,
                    'product_name' => $product['product_name'] ?? null,
                    'brands' => $product['brands'] ?? null,
                    'image' => $product['image_url'] ?? $product['image_front_url'] ?? $product['image_front_small_url'] ?? null,
                    'serving_size' => $cached->serving_size,
                    'serving_size_g' => $cached->serving_size_g,
                    'nutrition' => [
                        'energy_kcal_100g' => $product['nutriments']['energy-kcal_100g'] ?? null,
                        'fat_100g' => $product['nutriments']['fat_100g'] ?? null,
                        'saturated_fat_100g' => $saturatedFat,
                        'carbohydrates_100g' => $product['nutriments']['carbohydrates_100g'] ?? null,
                        'sugars_100g' => $sugars,
                        'fiber_100g' => $product['nutriments']['fiber_100g'] ?? null,
                        'proteins_100g' => $product['nutriments']['proteins_100g'] ?? null,
                        'salt_100g' => $product['nutriments']['salt_100g'] ?? null,
                        'sodium_100g' => $sodium,
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

        // ========================================
        // LAYER 3: AI Vision Required (Fallback)
        // ========================================
        // Product not found or nutrition data incomplete
        return response()->json([
            'source' => 'not_found',
            'barcode' => $barcode,
            'needs_ai_vision' => true,
            'message' => 'Produk tidak ditemukan atau data gizi tidak lengkap. Silakan foto label nutrisi.',
            // Include partial data if available from OFF
            'partial_data' => isset($product) ? [
                'product_name' => $product['product_name'] ?? null,
                'brands' => $product['brands'] ?? null,
                'image' => $product['image_url'] ?? null,
            ] : null,
        ], 200); // Return 200 so frontend can handle gracefully
    }

    /**
     * Save product from AI Vision extraction
     */
    public function storeFromAI(string $barcode, \Illuminate\Http\Request $request)
    {
        $nutritionData = $request->all();
        
        $food = Food::updateOrCreate(
            ['barcode' => $barcode],
            [
                'name' => $nutritionData['product_name'] ?? 'Unknown Product',
                'brand' => $nutritionData['brand'] ?? null,
                'image_url' => $nutritionData['image_url'] ?? null,
                'serving_size' => isset($nutritionData['serving_size']) ? $nutritionData['serving_size'] . 'g' : null,
                'serving_size_g' => $nutritionData['serving_size'] ?? null,
                'calories' => $nutritionData['energy_kcal_100g'] ?? null,
                'sugar_g' => $nutritionData['sugars_100g'] ?? null,
                'salt_mg' => isset($nutritionData['sodium_100g']) 
                    ? $nutritionData['sodium_100g'] * 1000 
                    : null,
                'fat_total_g' => $nutritionData['fat_100g'] ?? null,
                'fat_saturated_g' => $nutritionData['saturated_fat_100g'] ?? null,
                'protein_g' => $nutritionData['proteins_100g'] ?? null,
                'carbo_g' => $nutritionData['carbohydrates_100g'] ?? null,
            ]
        );

        // Calculate and update grade
        $sugarGrade = $this->getGrade('sugar', $food->sugar_g);
        $fatGrade = $this->getGrade('saturated_fat', $food->fat_saturated_g);
        $finalGrade = $this->getFinalGrade($sugarGrade, $fatGrade);
        
        $food->update(['grade' => $finalGrade]);

        return response()->json([
            'success' => true,
            'food_id' => $food->id,
            'grade' => $finalGrade,
        ]);
    }

    /**
     * Record consumption to scan history
     */
    public function consume(string $barcode, \Illuminate\Http\Request $request)
    {
        $food = Food::where('barcode', $barcode)->first();
        
        if (!$food) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        $quantity = $request->input('quantity', 1);
        
        // Calculate calories based on serving size
        // calories field stores calories per 100g
        // serving_size_g stores the actual serving size
        $servingSizeG = $food->serving_size_g ?? 100; // Default to 100g if not set
        $caloriesPer100g = $food->calories ?? 0;
        $caloriesPerServing = ($caloriesPer100g / 100) * $servingSizeG;
        $totalCalories = $caloriesPerServing * $quantity;

        \App\Models\ScanHistory::create([
            'user_id' => auth()->id(),
            'food_id' => $food->id,
            'quantity' => $quantity,
            'total_calories_intaken' => round($totalCalories, 2),
            'action_type' => 'consumed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Konsumsi tercatat',
            'quantity' => $quantity,
            'serving_size' => $servingSizeG,
            'calories_per_serving' => round($caloriesPerServing, 2),
            'total_calories' => round($totalCalories, 2),
        ]);
    }
}
