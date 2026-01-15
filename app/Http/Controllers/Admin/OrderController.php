<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Start detailed query to include relationships
        $query = Order::with(['user', 'items.product'])
            ->whereIn('status', ['paid', 'accepted']);

        // Filter Logic
        // "Using checkboxes to find accepted orders , and orders which have not been accepted and all the orders"
        // Interpreting this: 
        // - filter 'accepted' -> status 'accepted'
        // - filter 'unaccepted' -> status 'paid'
        // - filter 'all' -> reset/show both.

        $showAccepted = $request->query('filter_accepted');
        $showUnaccepted = $request->query('filter_unaccepted');
        $showAll = $request->query('filter_all');

        if ($showAll) {
            // Show everything (paid and accepted), no additional filtering needed beyond base scope
        } elseif ($showAccepted && !$showUnaccepted) {
            $query->where('status', 'accepted');
        } elseif ($showUnaccepted && !$showAccepted) {
            $query->where('status', 'paid');
        } 
        // If both are checked or neither are checked, we default to showing all matching base scope

        $orders = $query->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function accept(Order $order)
    {
        $order->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Order accepted successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
