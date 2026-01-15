<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.orders.index');
    }

    public function accept(Order $order)
    {
        $order->update(['status' => 'accepted']);

        // Clear session flash to avoid confusion if Livewire manages it
        return redirect()->back()->with('success', 'Order accepted successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }
}
