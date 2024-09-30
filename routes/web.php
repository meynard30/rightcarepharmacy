<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [OrderController::class, 'myOrders'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/dashboard/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/dashboard/products', ProductController::class);

    Route::get('/dashboard/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/dashboard/pos/add-to-cart', [POSController::class, 'addToCart'])->name('pos.addToCart');
    Route::post('/dashboard/pos/remove-from-cart', [POSController::class, 'removeFromCart'])->name('pos.removeFromCart');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');

    Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('orders.index');
    // Route::get('/dashboard/my-orders', [OrderController::class, 'myOrders'])->name('orders.myOrders');
    Route::get('/dashboard/orders/{id}', [OrderController::class, 'show'])->name('orders.show');


});

require __DIR__ . '/auth.php';
