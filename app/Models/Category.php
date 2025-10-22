<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $guarded = [];
    public function products(){ return $this->hasMany(Product::class); }
    public function productTypes()
    {
        return $this->hasMany(ProductType::class);
    }
}
