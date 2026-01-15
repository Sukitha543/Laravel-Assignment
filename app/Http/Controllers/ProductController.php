<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Display the products
    public function index()
    {
        return view('product');
    }

    public function show(Product $product)
    {
        return view('product-detail', compact('product'));
    }
   
}
