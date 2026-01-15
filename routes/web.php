<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Public Routes
Route::get('/', function () {return view('welcome');});
Route::get('/about', function () {return view('about');})->name('about');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');



//Auth Routes for users
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Admin only
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Customers should NOT stay here
        return redirect('/'); // homepage
    })->name('dashboard');
});

//Auth Routes for customers
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');

    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');

    Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');

});

//Auth Routes for admin
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin'
])->group(function () {

    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/products/create', [App\Http\Controllers\Admin\ProductController::class, 'showCreate'])->name('admin.products.show');
    Route::get('/admin/products',[App\Http\Controllers\Admin\ProductController::class,'showManage'])->name('admin.products.manage');
    Route::get('/admin/products/{product}/edit',[App\Http\Controllers\Admin\ProductController::class,'edit'])->name('admin.products.edit');

    // Order Management Routes
    Route::get('/admin/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');

});

