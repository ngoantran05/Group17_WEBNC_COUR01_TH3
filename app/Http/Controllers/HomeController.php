<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
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
