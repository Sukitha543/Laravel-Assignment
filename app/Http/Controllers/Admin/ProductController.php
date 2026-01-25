<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{ 
    // Opens the Add Products Page
    public function showCreate(){
        
        return view('admin.products.create');
    }

    // Store in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products,product_code',
            'diameter' => 'required|string|max:50',
            'type' => 'required|in:men,women',
            'material' => 'required|in:steel,plastic',
            'strap' => 'required|in:leather,steel',
            'water_resistance' => 'required|string|max:100',
            'caliber' => 'required|string|max:100|min:1',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        //Image Upload
        if ($request->hasFile('image')) {
            $result = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'products']);
            $validated['image'] = $result['secure_url'];
        }

        //Save Product
        Product::create($validated);

        //Redirect with success message
        return redirect()
            ->route('admin.products.show')
            ->with('success', 'Watch product has been added successfully!');
    }

    //Display the products
    public function showManage()
    {
        $products = Product::latest()->get();
        return view('admin.products.manage', compact('products'));
    }

    //Disply the product details to edit
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    //Store the updated product to the database
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
        'diameter' => 'required|string|max:50',
        'type' => 'required|in:men,women',
        'material' => 'required|in:steel,plastic',
        'strap' => 'required|in:leather,steel',
        'water_resistance' => 'required|string|max:100',
        'caliber' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Image update (optional)
    // Image update (optional)
    if ($request->hasFile('image')) {
        if (!filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->image);
        }
        $result = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'products']);
        $validated['image'] = $result['secure_url'];
    }

    $product->update($validated);

    return redirect()
        ->route('admin.products.manage')
        ->with('success', 'Watch updated successfully!');
    }

    //Delete the Product
    public function destroy(Product $product)
    {
        if (!filter_var($product->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()
            ->route('admin.products.manage')
            ->with('success', 'Watch deleted successfully!');
    }

}

