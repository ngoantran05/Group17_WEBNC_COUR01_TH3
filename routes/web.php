<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::resource('products', ProductController::class);
// Route::resource('orders', OrderController::class);
Route::get('/sanpham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// 1. Hiển thị trang giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// 2. Xử lý "Thêm vào giỏ hàng" (từ trang chi tiết sản phẩm)
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');

// 3. Xử lý "Mua ngay"
Route::post('/checkout/buy-now', function() {
    // Tạm thời
    dd(request()->all(), "ĐANG MUA NGAY"); 
})->name('checkout.buyNow');

// 4. Cập nhật số lượng (dùng $cartId)
Route::patch('/cart/update/{cartId}', [CartController::class, 'update'])->name('cart.update');

// 5. Xóa sản phẩm (dùng $cartId)
Route::delete('/cart/remove/{cartId}', [CartController::class, 'destroy'])->name('cart.destroy');

// 6. Xóa toàn bộ giỏ hàng
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

//ROUTE THANH TOÁN (CHECKOUT)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
//ROUTE KHUYẾN MÃI
Route::get('/khuyen-mai', [PromotionController::class, 'index'])->name('promotions.index');
//ROUTE TÀI KHOẢN(phải đăng nhập)
Route::middleware('auth')->group(function () {
    // Trang Thông tin cá nhân
    Route::get('/tai-khoan', [AccountController::class, 'show'])->name('account.show');
    // Xử lý Cập nhật
    Route::post('/tai-khoan', [AccountController::class, 'update'])->name('account.update');
    // Trang Lịch sử đơn hàng
    Route::get('/tai-khoan/don-hang', [AccountController::class, 'orders'])->name('account.orders');
});
//ROUTE LIÊN HỆ
Route::get('/lien-he', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/lien-he', [ContactController::class, 'submitForm'])->name('contact.submit');
//ROUTE TÌM KIẾM
Route::get('/search', [SearchController::class, 'index'])->name('search');
