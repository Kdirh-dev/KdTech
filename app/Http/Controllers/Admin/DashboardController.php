<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:admin,manager');
    // }

    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_repairs' => Repair::count(),
            'total_users' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'pending_repairs' => Repair::where('status', 'pending')->count(),
            'revenue' => Order::where('payment_status', true)->sum('total_amount'),
        ];

        $recentOrders = Order::with('items.product')
            ->latest()
            ->limit(5)
            ->get();

        $recentRepairs = Repair::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentRepairs'));
    }
}
