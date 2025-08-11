<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'sub_categories';

    protected $fillable = [
        'name', 'slug', 'description', 'category_id', 'image', 'status', 'created_by', 'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'N/A';
    }
}
