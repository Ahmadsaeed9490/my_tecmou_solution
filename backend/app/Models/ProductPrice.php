<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'min_price',
        'max_price',
        'discount_percent',
        'final_price',
        'currency',
        'status', // Add status to fillable
    ];

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
