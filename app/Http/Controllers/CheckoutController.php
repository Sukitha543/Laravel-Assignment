<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('checkout.index', compact('user', 'cartItems', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);

        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Create Order and Reserve Stock
        try {
            $order = \Illuminate\Support\Facades\DB::transaction(function () use ($user, $cartItems, $request) {
                
                $totalPrice = 0;
                
                // 1. Calculate Total & Reserve Stock
                foreach ($cartItems as $item) {
                     $product = Product::lockForUpdate()->find($item->product_id);
                     
                     if (!$product || $product->quantity < $item->quantity) {
                         throw new \Exception('Product ' . $item->product->brand . ' ' . $item->product->model . ' is out of stock.');
                     }
                     
                     // Reserve Stock (Reduce now)
                     $product->quantity -= $item->quantity;
                     $product->save();

                     $totalPrice += $item->product->price * $item->quantity;
                }

                // 2. Create Order (Pending)
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => 'pending', 
                    'total_price' => $totalPrice,
                    'session_id' => null, 
                ]);

                // 3. Create Order Items
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
                }

                // 4. Create Shipping Details
                $order->shippingDetail()->create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                ]);

                return $order;
            });

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        // Prepare Line Items for Stripe
        $lineItems = [];
        foreach ($cartItems as $item) {
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

        // Stripe Session
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['order_id' => $order->id]),
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => $user->id,
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

            // Find the order by session ID
            $order = Order::where('session_id', $sessionId)->first();

            if (!$order) {
                 return redirect()->route('cart.index')->with('error', 'Order not found.');
            }

            if ($order->status === 'paid') {
                 return view('checkout.success', compact('order'));
            }

            if ($order->status === 'pending') {
                $order->update(['status' => 'paid']);

                // Clear Cart
                CartItem::where('user_id', Auth::id())->delete();
            }

            return view('checkout.success', compact('order'));



        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');

        if ($orderId) {
            $order = Order::where('id', $orderId)
                          ->where('user_id', Auth::id()) // Security check
                          ->where('status', 'pending')
                          ->first();
            
            if ($order) {
                // Restore Stock
                foreach ($order->items as $item) {
                     $product = Product::find($item->product_id);
                     if ($product) {
                         $product->quantity += $item->quantity;
                         $product->save();
                     }
                }

                $order->delete(); // Cascades to items and shipping details
            }
        }

        return view('checkout.cancel');
    }
}
