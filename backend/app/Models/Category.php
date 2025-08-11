<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{

        use SoftDeletes;
        protected $dates = ['deleted_at'];

   protected $fillable = [
    'name',
    'slug',
    'description',
    'image',
    'status',
    'parent_id'
];

    public function products()
    {
        return $this->hasMany(Product::class);
    }   
}
