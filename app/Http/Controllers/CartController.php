<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

    use App\Models\CartItem;
    use App\Models\Product;
    use Illuminate\Support\Facades\Auth;

    class CartController extends Controller
    {
        public function index()
        {
            return view('cart');
        }

        public function store(Request $request, Product $product)
        {
            // Check if product already in cart
            $exists = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return redirect()->route('cart.index')->with('error', 'Item has already been added to the cart.');
            }

            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1
            ]);

            return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
        }

        public function destroy(CartItem $cartItem)
        {
            if ($cartItem->user_id !== Auth::id()) {
                abort(403);
            }
            
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
        }
    }
