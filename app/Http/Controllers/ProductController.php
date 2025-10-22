<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\Size;
use App\Models\Color;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $requestFilters = [
            'categories' => $request->input('categories', []),
            'sizes' => $request->input('sizes', []),
            'colors' => $request->input('colors', []),
            'genders' => $request->input('genders', []), 
        ];
        $query = Product::query()->where('is_active', true);
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->input('categories'));
        }

        
        if ($request->filled('types')) {
            $query->whereIn('product_type_id', $request->input('types'));
        }

        // Lọc theo Mức giá (prices)
        if ($request->filled('prices')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->input('prices') as $range) {
                    $parts = explode('-', $range); // Tách chuỗi "100000-200000"
                    if (count($parts) == 2) {
                        $q->orWhereBetween('price', [$parts[0], $parts[1]]);
                    }
                }
            });
        }

        // Lọc theo Size (dùng quan hệ many-to-many -> whereHas)
        if ($request->filled('sizes')) {
            $query->whereHas('sizes', function ($q) use ($request) {
                $q->whereIn('size_id', $request->input('sizes'));
            });
        }

        // Lọc theo Màu sắc (dùng quan hệ many-to-many -> whereHas)
        if ($request->filled('colors')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('color_id', $request->input('colors'));
            });
        }
        $query->when($requestFilters['genders'], function ($q, $genders) {
            $q->whereIn('gender', $genders);
        });

        // 3. XỬ LÝ SẮP XẾP (SORTING)
        $sortBy = $request->input('sort_by', 'moi-nhat'); // Mặc định là 'mới nhất'

        switch ($sortBy) {
            case 'gia-thap-cao':
                $query->orderBy('price', 'asc');
                break;
            case 'gia-cao-thap':
                $query->orderBy('price', 'desc');
                break;
            case 'moi-nhat':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 4. LẤY KẾT QUẢ PHÂN TRANG
        $products = $query->paginate(12)->appends($request->query()); // 9 sản phẩm/trang

        // 5. LẤY DỮ LIỆU CHO SIDEBAR FILTER
        $categories = Category::all();
        $productTypes = ProductType::all();
        $sizes = Size::all();
        $colors = Color::all();
        $genders = [
            'male' => 'Nam',
            'female' => 'Nữ',
            'unisex' => 'Unisex'
        ];
        $priceRanges = [
            '0-100000' => 'Dưới 100.000đ',
            '100000-200000' => 'Từ 100.000đ - 200.000đ',
            '200000-300000' => 'Từ 200.000đ - 300.000đ',
            '300000-500000' => 'Từ 300.000đ - 500.000đ',
            '500000-1000000' => 'Từ 500.000đ - 1 triệu',
        ];

        // 6. TRẢ VỀ VIEW VÀ TRUYỀN DỮ LIỆU
        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'productTypes' => $productTypes,
            'sizes' => $sizes,
            'colors' => $colors,
            'priceRanges' => $priceRanges,
            'genders' => $genders,
            'input' => $request->all() // (Tùy chọn) Gửi lại để checked các ô
        ]);
    }

    /**
     * === BỔ SUNG HÀM NÀY ===
     * Hiển thị trang chi tiết một sản phẩm.
     */
    public function show($slug)
    {
        // Tìm sản phẩm theo 'slug', nếu không thấy sẽ báo lỗi 404
        $product = Product::where('slug', $slug)
                            ->where('is_active', true)
                            ->with(['category', 'productType', 'sizes', 'colors']) // Lấy kèm data quan hệ
                            ->firstOrFail();

        // Lấy các sản phẩm liên quan
        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id)
                                    ->where('is_active', true)
                                    ->limit(4)
                                    ->get();

        return view('products.show', [ // Bạn sẽ cần tạo view 'products.show'
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    /**
     * ==========================================================
     * CÁC HÀM DÀNH CHO QUẢN LÝ (ADMIN PANEL - CRUD)
     * (Giữ nguyên code của bạn)
     * ==========================================================
     */

    /**
     * Hiển thị form thêm sản phẩm
     */
    public function create()
    {
        // (Nâng cấp) Bạn nên truyền cả danh mục, loại... vào đây
        $categories = Category::all();
        return view('products.create', compact('categories'));
        return view('products.create');
    }

    /**
     * Lưu sản phẩm mới vào cơ sở dữ liệu
     */
    public function store(Request $request)
    {
        // Bạn cần validate thêm các trường mới như slug, category_id...
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'product_line' => 'required|string|max:255', // Cột này không có trong migration
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Ví dụ
            'slug' => 'required|unique:products,slug', // Ví dụ
        ]);

        $product = Product::create($validated);
        
        // (Nâng cấp) Lưu quan hệ many-to-many
        if ($request->has('sizes')) {
            $product->sizes()->attach($request->input('sizes'));
        }
        if ($request->has('colors')) {
            $product->colors()->attach($request->input('colors'));
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
        // CHÚ Ý: route('products.index') giờ sẽ trỏ về trang LỌC SẢN PHẨM.
        // Bạn nên tạo một route riêng cho admin, ví dụ 'admin.products.index'
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // (Nâng cấp) Tải các quan hệ và data cho form
        $categories = Category::all();
        $product->load('sizes', 'colors');
        return view('products.edit', compact('product', 'categories'));
        return view('products.edit', compact('product'));
    }

    /**
     * Cập nhật thông tin sản phẩm
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'product_line' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug,' . $product->id, // Bỏ qua chính nó
        ]);

        $product->update($validated);

        // (Nâng cấp) Cập nhật quan hệ many-to-many (dùng sync)
        $product->sizes()->sync($request->input('sizes', []));
        $product->colors()->sync($request->input('colors', []));

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // (Nâng cấp) Xóa các quan hệ pivot trước nếu cần
        $product->sizes()->detach();
        $product->colors()->detach();
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}