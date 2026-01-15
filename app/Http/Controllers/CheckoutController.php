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
        $totalPrice = 0;

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

            $totalPrice += $item->product->price * $item->quantity;
        }

        // Create Order (Pending)
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'session_id' => null, // will update later
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'order_id' => $order->id,
            ],
            // Collect shipping address if needed
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'CA', 'GB', 'LK'], // Add relevant countries
            ],
        ]);

        $order->update(['session_id' => $session->id]);

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
            
            // Should be using metadata, but session_id search is safe too
            $order = Order::where('session_id', $sessionId)->first();

            if (!$order) {
                 return redirect()->route('cart.index')->with('error', 'Order not found.');
            }

            if ($order->status === 'pending') {
                $order->update(['status' => 'paid']);

                // Reduce stock
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->quantity -= $item->quantity;
                        $product->save();
                    }
                }

                // Clear Cart
                CartItem::where('user_id', $order->user_id)->delete();

                // Send Email
                Mail::to($order->user)->send(new OrderPaid($order));
            }

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
