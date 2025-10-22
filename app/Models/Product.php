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
        'stock',
        'sold_quantity',
        'main_image_url',
        'is_active',
        'category_id',
        'gender',
        'product_type_id',
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }
}
