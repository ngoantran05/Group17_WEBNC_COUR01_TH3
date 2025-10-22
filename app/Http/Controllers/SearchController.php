<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import model Product

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $productsQuery = Product::where('is_active', true);

        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%');
            });
        } else {
            $productsQuery->where('id', '=', 0); 
        }
        $products = $productsQuery->paginate(12);
        return view('search.results', compact('products', 'query'));
    }
}
