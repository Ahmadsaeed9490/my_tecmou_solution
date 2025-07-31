<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ProductPrice
 extends Model
{

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'min_price',
        'max_price',
        'discount_percent',
        'final_price',
        'currency',
    ];
}

