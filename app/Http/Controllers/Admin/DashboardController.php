<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $todayRevenue = Order::where('status', 'completed')
                             ->whereDate('created_at', Carbon::today())
                             ->sum('total_amount');
        $monthRevenue = Order::where('status', 'completed')
                             ->whereYear('created_at', Carbon::now()->year)
                             ->whereMonth('created_at', Carbon::now()->month)
                             ->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalCustomers = User::where('role', 'user')->count(); 
        $latestOrders = Order::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalRevenue', 'todayRevenue', 'monthRevenue', 'totalOrders',
            'pendingOrders', 'completedOrders', 'totalCustomers', 'latestOrders'
        ));
    }
}