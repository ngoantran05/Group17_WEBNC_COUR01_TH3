<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{

    public function show(Product $product)
    {
        if ($product->status != 'available' || !$product->category->is_active) {
            abort(404); 
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id) 
                                    ->where('status', 'available')
                                    ->latest()
                                    ->take(4)
                                    ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $products = $category->products()
                             ->where('status', 'available')
                             ->latest()
                             ->paginate(12);
                             
        return view('shop.category', compact('products', 'category'));
    }

    public function index()
    {
        $products = Product::where('status', 'available')
                             ->latest()
                             ->paginate(12);
                             
        return view('shop.index', compact('products'));
    }
}