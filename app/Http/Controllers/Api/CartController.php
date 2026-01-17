<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // GET /api/cart
    public function index(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'total' => $total
        ]);
    }

    // POST /api/cart/add/{product}
    public function store(Request $request, Product $product)
    {
        $exists = CartItem::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Item already in cart'
            ], 409);
        }

        CartItem::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart'
        ], 201);
    }

    // DELETE /api/cart/{cartItem}
    public function destroy(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}

