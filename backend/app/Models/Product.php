<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
        protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'model',
        'category_id',
        'brand_id',
        'price',
        'discount',
        'stock_quantity',
        'warranty',
        'status',
        'is_featured',
        'description',
        'specifications',
        'thumbnail',
        'gallery_images',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    // Optional: relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
