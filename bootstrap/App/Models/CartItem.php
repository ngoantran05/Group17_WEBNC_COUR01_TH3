<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model {
    protected $fillable = [
        'cart_id', 
        'product_id', 
        'size_id', 
        'color_id', 
        'quantity', 
        'price_snapshot'
    ];
    public function product(){ return $this->belongsTo(Product::class); }
    public function cart(){ return $this->belongsTo(Cart::class); }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
