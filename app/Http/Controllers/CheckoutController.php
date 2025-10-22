<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; 
use App\Models\Discount; 

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn rỗng!');
        }
        session()->forget('checkout_totals');

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shippingFee = 30000; 
        $total = $subtotal + $shippingFee;

        $user = Auth::user();

        return view('checkout.index', compact('cart', 'user', 'subtotal', 'shippingFee', 'total'));
    }
    public function applyDiscount(Request $request)
    {
        $code = $request->input('discount_code');

        $discount = Discount::where('code', $code)->first();

        if (!$discount) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại.'], 404);
        }
        if (!$discount->isValid()) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'], 404);
        }

        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) { $subtotal += $item['price'] * $item['quantity']; }
        $shippingFee = 30000;

        $discountAmount = 0;
        if ($discount->type === 'percent') {
            $discountAmount = $subtotal * ($discount->value / 100);
        } else { 
            $discountAmount = $discount->value;
            if ($discountAmount > $subtotal) {
                $discountAmount = $subtotal;
            }
        }
        
        $newSubtotal = $subtotal - $discountAmount;
        $newTotal = $newSubtotal + $shippingFee;

        session()->put('checkout_totals', [
            'subtotal' => $newSubtotal,
            'shipping_fee' => $shippingFee,
            'total' => $newTotal,
            'discount_code' => $code, 
            'discount_id' => $discount->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'newSubtotalFormatted' => number_format($newSubtotal, 0, ',', '.'),
            'newShippingFormatted' => number_format($shippingFee, 0, ',', '.'),
            'newTotalFormatted' => number_format($newTotal, 0, ',', '.'),
        ]);
    }

    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Giỏ hàng của bạn rỗng!');
        }

        DB::beginTransaction();
        
        try {
            $totals = session()->get('checkout_totals');
            $discountId = null; 
            if ($totals && $totals['discount_code'] == $request->input('discount_code')) {
                $subtotal = $totals['subtotal'];
                $shippingFee = $totals['shipping_fee'];
                $total = $totals['total'];
                $discountId = $totals['discount_id'];
            } else {
                $subtotal = 0;
                foreach ($cart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                $shippingFee = 30000;
                $total = $subtotal + $shippingFee;
            }
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'province' => $request->province,
                'district' => $request->district,
                'ward' => $request->ward,
                'address' => $request->address,
                'note' => $request->note,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart as $cartId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'size_name' => $item['size_name'],
                    'color_name' => $item['color_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
                
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }
            
            if ($discountId) {
                $discount = Discount::find($discountId);
                if ($discount) {
                    $discount->increment('usage_count');
                }
            }

            DB::commit();

            session()->forget('cart');
            session()->forget('checkout_totals');
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function success()
    {
        if (!session('success')) {
            return redirect()->route('home');
        }
        return view('checkout.success');
    }
}