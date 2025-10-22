<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'size_name', 
        'color_name', 'price', 'quantity',
    ];
    public function product(){ return $this->belongsTo(Product::class); }
    public function order(){ return $this->belongsTo(Order::class); }
}
