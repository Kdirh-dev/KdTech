<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->limit(5)
            ->get();

        $recentRepairs = Repair::where('customer_email', $user->email)
            ->latest()
            ->limit(5)
            ->get();

        return view('frontend.user.dashboard', compact('user', 'recentOrders', 'recentRepairs'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('frontend.user.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);

        return view('frontend.user.order-detail', compact('order'));
    }

    public function repairs()
    {
        $repairs = Repair::where('customer_email', Auth::user()->email)
            ->latest()
            ->paginate(10);

        return view('frontend.user.repairs', compact('repairs'));
    }
}
