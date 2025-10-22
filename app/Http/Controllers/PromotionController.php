<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount; // Import model Discount

class PromotionController extends Controller
{
    /**
     * Hiển thị trang danh sách khuyến mãi
     */
    public function index()
    {
        // Lấy tất cả mã còn hiệu lực:
        // 1. Đang được 'is_active'
        // 2. Không hết hạn (NULL hoặc expires_at > now)
        // 3. Còn lượt sử dụng (NULL hoặc usage_count < usage_limit)
        
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