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

    // Add relationship with ProductPrice for automatic status synchronization
    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Boot method to automatically sync product prices status
     */
    protected static function boot()
    {
        parent::boot();

        // When product status is updated, sync all related product prices
        static::updated(function ($product) {
            if ($product->wasChanged('status') || $product->wasChanged('deleted_at')) {
                $product->syncProductPricesStatus();
            }
        });

        // When product is deleted, deactivate all related product prices
        static::deleted(function ($product) {
            $product->productPrices()->update(['status' => 0]);
        });

        // When product is restored, reactivate product prices if product is active
        static::restored(function ($product) {
            if ($product->status) {
                $product->productPrices()->update(['status' => 1]);
            }
        });
    }

    /**
     * Sync all related product prices status with current product status
     */
    public function syncProductPricesStatus()
    {
        $newStatus = $this->status && !$this->deleted_at ? 1 : 0;
        $this->productPrices()->update(['status' => $newStatus]);
    }
}
