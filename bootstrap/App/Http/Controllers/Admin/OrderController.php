<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD:app/Http/Controllers/Admin/OrderController.php
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product'); 
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);


        $order->update(['status' => $request->status]);
  
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
=======
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
>>>>>>> beb7118925419201d7995865ab9e21a0f7c66f4a:bootstrap/App/Http/Controllers/Admin/OrderController.php
