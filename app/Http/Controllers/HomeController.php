<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
                                    ->inRandomOrder() 
                                    ->limit(4)
                                    ->get();

        $categorySlugs = ['ao', 'quan', 'giay-dep', 'phu-kien'];
        $featuredCategories = Category::whereIn('slug', $categorySlugs)->get();
        $promotions = Discount::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                      ->orWhereRaw('usage_count < usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        return view('home', [
            'featuredProducts' => $featuredProducts,
            'featuredCategories' => $featuredCategories,
            'promotions' => $promotions,
        ]);
    }
}
