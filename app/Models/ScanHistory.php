<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScanHistory extends Model
{
    use HasFactory;

    protected $table = 'scan_histories';

    protected $fillable = [
        'user_id',
        'food_id',
        'quantity',
        'total_calories_intaken',
        'action_type', // 'scan_only', 'consumed'
    ];

    protected function casts(): array
    {
        return [
            'total_calories_intaken' => 'decimal:2',
            'quantity' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}