<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sizes',
        'colors',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
