<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount; 

class PromotionController extends Controller
{
    public function index()
    {
        
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
            ->get();

        return view('promotions.index', compact('promotions'));
    }
}