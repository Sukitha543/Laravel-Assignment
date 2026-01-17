<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        foreach ($cartItems as $item) {

            if ($item->product->quantity < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product out of stock: ' .
                        $item->product->brand . ' ' . $item->product->model
                ], 400);
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
            'session_id' => null,
        ]);

        // Create Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Stripe Checkout Session
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',

            // IMPORTANT: frontend URLs (Flutter handles these)
            'success_url' => config('app.frontend_url') . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => config('app.frontend_url') . '/payment-cancel',

            'metadata' => [
                'order_id' => $order->id,
            ],

            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'CA', 'GB', 'LK'],
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

                // Reduce stock
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->quantity -= $item->quantity;
                        $product->save();
                    }
                }

                // Clear cart
                CartItem::where('user_id', $order->user_id)->delete();

                // Send confirmation email
                Mail::to($order->user)->send(new OrderPaid($order));
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
}

