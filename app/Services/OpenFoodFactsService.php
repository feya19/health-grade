<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenFoodFactsService
{
    public function getProduct(string $barcode): array
    {
        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->get("https://world.openfoodfacts.org/api/v2/product/{$barcode}");

            if ($response->failed()) {
                Log::warning("OpenFoodFacts API failed for barcode: {$barcode}", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'status' => 0,
                    'status_verbose' => 'API request failed'
                ];
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error("OpenFoodFacts API exception for barcode: {$barcode}", [
                'message' => $e->getMessage()
            ]);

            return [
                'status' => 0,
                'status_verbose' => 'Connection error'
            ];
        }
    }
}
