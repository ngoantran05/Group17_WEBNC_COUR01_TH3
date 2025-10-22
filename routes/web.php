<?php
use Illuminate\Support\Facades\Route;
// Import Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
// Import User Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;

// === USER FACING ROUTES ===
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product:slug}', [ShopController::class, 'show'])->name('product.show');
Route::get('/category/{category:slug}', [ShopController::class, 'category'])->name('category.show');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index'); // Trang shop tổng

// Route 'dashboard' mặc định của Breeze (cho user thường)
Route::get('/dashboard', function () {
    // Nếu là admin, tự động chuyển về admin dashboard
    if (auth()->check() && auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Nếu là user, cho xem trang profile
    return view('dashboard'); 
})->middleware(['auth', 'verified'])->name('dashboard');

// Route profile của Breeze
Route::middleware('auth')->group(function () {
    // ProfileController...
});

// Import file auth.php của Breeze
require __DIR__.'/auth.php';

// === ADMIN ROUTES ===
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/update-status', [ProductController::class, 'updateStatus'])->name('products.updateStatus');

    Route::resource('categories', CategoryController::class);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::resource('users', UserController::class)->except(['create', 'store']);
});
