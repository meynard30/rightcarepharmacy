<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        // Fetch orders for the authenticated user
        $orders = Order::latest()->get();

        return view('dashboard.order.index', compact('orders'));
    }

    public function myOrders()
    {
        // Fetch orders for the authenticated user
        $orders = Order::where('user_id', auth()->id())->get();

        return view('dashboard.order.my-orders', compact('orders'));
    }

    public function show($id)
    {
        // Find the order by ID and make sure it belongs to the authenticated user
        $order = Order::with('orderItems.product')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        return view('dashboard.order.show', compact('order'));
    }
}
