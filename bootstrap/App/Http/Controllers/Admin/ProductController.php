<?php
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
