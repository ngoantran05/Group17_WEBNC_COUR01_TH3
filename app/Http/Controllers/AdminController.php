<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $orders = Order::count();
        $products = Product::count();
        $users = User::count();
        $revenue = Order::sum('total');
        return view('admin.dashboard', compact('orders', 'products', 'users', 'revenue'));
    }

    public function products()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function addProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);
        Product::create($data);
        return redirect()->route('admin.products')->with('success', 'Đã thêm sản phẩm!');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
    }

    public function orders()
    {
        $orders = Order::with('user')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrder($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->status = $status;
        $order->save();
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng!');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}
