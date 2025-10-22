<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import model Product

class SearchController extends Controller
{
    /**
     * Hiển thị trang kết quả tìm kiếm
     */
    public function index(Request $request)
    {
        // 1. Lấy từ khóa tìm kiếm từ URL (?query=...)
        $query = $request->input('query');

        // 2. Tạo một truy vấn cơ sở
        $productsQuery = Product::where('is_active', true);

        // 3. Chỉ tìm kiếm nếu $query có giá trị
        if ($query) {
            // Tìm trong Tên SẢN PHẨM hoặc MÔ TẢ
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhere('description', 'LIKE', '%' . $query . '%');
            });
        } else {
            // Nếu không có từ khóa, trả về 0 kết quả
            $productsQuery->where('id', '=', 0); // Trả về rỗng
        }

        // 4. Lấy kết quả (phân trang 12 sản phẩm/trang)
        $products = $productsQuery->paginate(12);

        // 5. Trả về view
        return view('search.results', compact('products', 'query'));
    }
}
