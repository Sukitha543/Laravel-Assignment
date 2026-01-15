<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Customers (Users who are not admins)
        // Assuming 'role' defaults to 'customer' or similar. 
        // Based on web.php, we check role === 'admin'. 
        // We will count users where role is 'customer' or just not admin.
        // Let's assume explicit 'customer' role or null/default. 
        // Safer to count where role != 'admin' or role = 'customer'.
        // I will check if I can find where 'customer' is set. 
        // In the absence of explicit 'customer' role assignment code, I'll assume users with role != 'admin' are customers.
        $totalCustomers = User::where('role', '!=', 'admin')->count();

        // 2. Total Products
        $totalProducts = Product::count();

        // 3. Total Orders
        $totalOrders = Order::count();

        // 4. Total Revenue (Accepted orders only)
        $totalRevenue = Order::where('status', 'accepted')->sum('total_price');

        return view('admin.dashboard', compact('totalCustomers', 'totalProducts', 'totalOrders', 'totalRevenue'));
    }
}
