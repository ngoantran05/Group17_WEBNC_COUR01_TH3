<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::resource('products', ProductController::class);


Route::patch('products/{product}/toggle-active', [ProductController::class, 'toggleActive'])
    ->name('products.toggleActive');

