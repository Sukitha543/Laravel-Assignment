<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Action Routes (Authentication required)
Route::middleware([
    'web',
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Cart Actions
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cartItem}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    // Favorite Actions
    Route::post('/favorites/add/{product}', [App\Http\Controllers\FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [App\Http\Controllers\FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Checkout Action
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');

});

// Admin Action Routes
Route::middleware([
    'web',
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin'
])->group(function () {

    Route::post('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store'); 
    Route::put('/admin/products/{product}',[App\Http\Controllers\Admin\ProductController::class,'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}',[App\Http\Controllers\Admin\ProductController::class,'destroy'])->name('admin.products.destroy');
    
    // Order Actions
    Route::patch('/admin/orders/{order}/accept', [App\Http\Controllers\Admin\OrderController::class, 'accept'])->name('admin.orders.accept');
    Route::delete('/admin/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');

});
