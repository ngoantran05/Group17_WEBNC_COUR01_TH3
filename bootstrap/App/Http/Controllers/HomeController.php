<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD:app/Http/Controllers/HomeController.php
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ.
     */
    public function index()
    {
        $latestProducts = Product::where('status', 'available')
                                 ->latest()
                                 ->take(8)
                                 ->get();

        $categories = Category::where('is_active', true)
                                ->orderBy('order')
                                ->get();

        return view('home', compact('latestProducts', 'categories'));
    }
}
=======

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
>>>>>>> beb7118925419201d7995865ab9e21a0f7c66f4a:bootstrap/App/Http/Controllers/HomeController.php
