<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size; 
use App\Models\Color;

class CartController extends Controller
{
    
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('cart.cart', compact('cart', 'totalPrice'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $size = $request->size_id ? Size::find($request->size_id) : null;
        $color = $request->color_id ? Color::find($request->color_id) : null;
        $cartId = $product->id . '-' . ($size->id ?? '0') . '-' . ($color->id ?? '0');
        $cart = session()->get('cart', []);
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $request->quantity;
        } else {
            $cart[$cartId] = [
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->main_image_url, 
                "slug" => $product->slug,
                "size_name" => $size->name ?? null, 
                "color_name" => $color->name ?? null, 
            ];
        }
        
        session()->put('cart', $cart);
       
        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ!');
    }

    public function update(Request $request, $cartId) 
    {
        $cart = session()->get('cart');

        if ($request->quantity <= 0) {
            return $this->destroy($cartId); 
        }
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    public function destroy($cartId) 
    {
        $cart = session()->get('cart');
        unset($cart[$cartId]); 
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm!');
    }
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
