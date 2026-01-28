<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    // POST /api/checkout
    public function checkout(Request $request)
    {
        $user = $request->user();

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        $lineItems = [];
        $totalPrice = 0;

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);
        
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
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
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
            'success_url' => config('app.frontend_url') . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => config('app.frontend_url') . '/payment-cancel?order_id=' . $order->id,
            'metadata' => [
                'order_id' => $order->id,
                'user_id' => $user->id,
            ],
        ]);

        $order->update(['session_id' => $session->id]);

        return response()->json([
            'success' => true,
            'checkout_url' => $session->url,
            'order_id' => $order->id
        ]);
    }

    // GET /api/checkout/success
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid session'
            ], 400);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);

            $order = Order::where('session_id', $sessionId)->first();

            if (! $order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if ($order->status === 'pending') {
                $order->update(['status' => 'paid']);

                // Clear cart
                CartItem::where('user_id', $order->user_id)->delete();

                // Send confirmation email

            }

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'order' => $order
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // GET /api/checkout/cancel
    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');

        if (! $orderId) {
             return response()->json([
                'success' => false,
                'message' => 'Order ID is required'
            ], 400);
        }

        $order = Order::where('id', $orderId)
                        ->where('user_id', $request->user()->id) // Security check
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

            $order->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Order not found or cannot be cancelled'
        ], 404);
    }
}

