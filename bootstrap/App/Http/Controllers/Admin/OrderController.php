<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::with('user','orderItems.product')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id) {
        $order = Order::with('user','orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->route('orders.index');
    }

    public function stats() {
        $totalRevenue = Order::where('status','completed')->sum('total');
        $ordersCount = Order::count();
        return view('admin.stats', compact('totalRevenue','ordersCount'));
    }
}
