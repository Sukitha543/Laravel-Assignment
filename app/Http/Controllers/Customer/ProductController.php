<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Display the products
    public function index()
    {
        $products = Product::where('quantity', '>', 0)
        ->latest()
        ->paginate(9);
        return view('product', compact('products'));
    }

    public function show(Product $product)
    {
        return view('product-detail', compact('product'));
    }
   
}
