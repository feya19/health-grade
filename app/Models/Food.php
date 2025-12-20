<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'barcode',
        'name',
        'brand',
        'serving_size',
        'serving_size_g',
        'calories',
        'sugar_g',
        'salt_mg',
        'fat_total_g',
        'fat_saturated_g',
        'protein_g',
        'carbo_g',
        'cholesterol_mg',
        'grade',
        'nutri_score_details',
        'fatsecret_id',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'serving_size_g' => 'decimal:2',
            'calories' => 'decimal:2',
            'sugar_g' => 'decimal:2',
            'salt_mg' => 'decimal:2',
            'fat_total_g' => 'decimal:2',
            'nutri_score_details' => 'array', // Otomatis convert JSONB ke Array PHP
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    
    public function scanHistories(): HasMany
    {
        return $this->hasMany(ScanHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    // Helper warna background grade untuk UI Tailwind
    // Cara pakai: <div class="{{ $food->grade_color }}">
    public function getGradeColorAttribute(): string
    {
        return match ($this->grade) {
            'A' => 'bg-green-500',
            'B' => 'bg-lime-500',
            'C' => 'bg-yellow-400',
            'D' => 'bg-red-500',
            default => 'bg-gray-400',
        };
    }
}