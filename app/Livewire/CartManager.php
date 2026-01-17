<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartManager extends Component
{
    public function remove($cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);

        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $cartItem->delete();
            session()->flash('success', 'Item removed from cart.');
        }
    }

    public function render()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('livewire.cart-manager', compact('cartItems', 'total'));
    }
}
