<?php
<<<<<<< HEAD:app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class ProductController extends Controller
{

    public function index()
    {

        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products', 
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'status' => 'required|in:available,out_of_stock',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'image' => $path,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function show(Product $product)
    {

        return redirect()->route('admin.products.edit', $product);
    }


    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id, // Sửa unique
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,out_of_stock',
        ]);

        $path = $product->image; 

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'image' => $path,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công.');
    }

    public function updateStatus(Request $request, Product $product)
    {
        $request->validate(['status' => 'required|in:available,out_of_stock']);
        $product->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }
}
=======
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric',
            'category_id'=>'required',
            'size'=>'nullable',
            'color'=>'nullable',
            'in_stock'=>'required|boolean',
            'image'=>'nullable|image|max:2048'
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('products','public');
            $data['image'] = $path;
        }

        Product::create($data);
        return redirect()->route('products.index');
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $data = $request->validate([
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric',
            'category_id'=>'required',
            'size'=>'nullable',
            'color'=>'nullable',
            'in_stock'=>'required|boolean',
            'image'=>'nullable|image|max:2048'
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('products','public');
            $data['image'] = $path;
        }

        $product->update($data);
        return redirect()->route('products.index');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index');
    }
}
>>>>>>> beb7118925419201d7995865ab9e21a0f7c66f4a:bootstrap/App/Http/Controllers/Admin/ProductController.php
