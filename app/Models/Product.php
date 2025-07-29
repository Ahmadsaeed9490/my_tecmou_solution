<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'category_id',
        'brand_id',
        'model',
        'description',
        'specifications',
        'price',
        'discount',
        'stock_quantity',
        'warranty',
        'status',
        'is_featured',
        'thumbnail',
        'gallery_images',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}