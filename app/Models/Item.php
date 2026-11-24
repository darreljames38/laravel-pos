<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'category',
        'description',
        'selling_price',
        'stock_quantity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'selling_price' => 'decimal:2',
            'stock_quantity' => 'integer',
        ];
    }
}