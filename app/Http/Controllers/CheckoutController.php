<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Mail\OrderPaid;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $lineItems = [];

        foreach ($cartItems as $item) {
            if ($item->product->quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', 'Product ' . $item->product->brand . ' ' . $item->product->model . ' is out of stock.');
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->brand . ' ' . $item->product->model,
                    ],
                    'unit_amount' => (int)($item->product->price * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'user_id' => $user->id,
            ],
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'CA', 'GB', 'LK'], 
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('cart.index')->with('error', 'Invalid session.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);

            if (!$session) {
                return redirect()->route('cart.index')->with('error', 'Invalid session.');
            }

            // Check if order already exists to prevent duplicate creation on refresh
            $existingOrder = Order::where('session_id', $sessionId)->first();
            if ($existingOrder) {
                 return view('checkout.success', compact('existingOrder'));
            }

            $user = Auth::user();
            
            // Re-fetch cart items
            $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
            
            if ($cartItems->isEmpty()) {
                 // Fallback or error if cart is somehow empty (e.g. cleared in another tab)
                 // Or we could rely on session amount?
                 // For now, assume cart is still valid.
                 return redirect()->route('cart.index')->with('error', 'Cart is empty. Was the order already processed?');
            }
            
            $totalPrice = $session->amount_total / 100;

            // Create Order (Pending by default as requested)
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', 
                'total_price' => $totalPrice,
                'session_id' => $session->id,
            ]);

            foreach ($cartItems as $item) {
                // Check stock again or just proceed? Assuming paid means proceeded.
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Reduce stock
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity -= $item->quantity;
                    $product->save();
                }
            }

            // Clear Cart
            CartItem::where('user_id', $user->id)->delete();

            // Send Email
            Mail::to($user)->send(new OrderPaid($order));

            return view('checkout.success', compact('order'));

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
