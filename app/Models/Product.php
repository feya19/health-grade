<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $guarded = [];

    protected $casts = [
        'nutrition' => 'array',
        'health_grade' => 'array',
    ];
}
