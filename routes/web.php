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
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cartItem}', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/add/{product}', [App\Http\Controllers\FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [App\Http\Controllers\FavoriteController::class, 'destroy'])->name('favorites.destroy');

});

//Auth Routes for admin
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin'
])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/products/create', [App\Http\Controllers\Admin\ProductController::class, 'showCreate'])->name('admin.products.show');
    Route::post('/admin/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store'); 
    Route::get('/admin/products',[App\Http\Controllers\Admin\ProductController::class,'showManage'])->name('admin.products.manage');
    Route::get('/admin/products/{product}/edit}',[App\Http\Controllers\Admin\ProductController::class,'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}',[App\Http\Controllers\Admin\ProductController::class,'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}',[App\Http\Controllers\Admin\ProductController::class,'destroy'])->name('admin.products.destroy');

});

