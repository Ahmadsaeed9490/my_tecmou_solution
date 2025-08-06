<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
        use SoftDeletes; // ✅ enable soft deletes

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'status',

        'created_by',
        'updated_by',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}