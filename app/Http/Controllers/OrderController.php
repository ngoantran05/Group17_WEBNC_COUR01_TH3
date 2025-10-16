<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng trống!');
        }
        return view('orders.checkout', compact('cart'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (!$cart) {
            return redirect()->route('products.index');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $order->payment_method = $request->payment_method;
        $order->status = 'Chờ xử lý';
        $order->save();

        foreach ($cart as $id => $details) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget('cart');
        return redirect()->route('orders.history')->with('success', 'Đặt hàng thành công!');
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.history', compact('orders'));
    }
}
