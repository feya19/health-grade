<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAssistant extends Model
{
    use HasFactory;

    // Definisikan nama tabel secara eksplisit karena bentuknya singular di migrasi
    protected $table = 'ai_assistant'; 

    protected $fillable = [
        'user_id',
        'food_id',
        'user_prompt',
        'ai_response',
        'context_data',
    ];

    protected function casts(): array
    {
        return [
            'context_data' => 'array', // Convert JSONB ke Array
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