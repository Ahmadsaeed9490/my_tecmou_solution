<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id',
        'min_price',
        'max_price',
        'discount_percent',
        'final_price',
        'currency',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}