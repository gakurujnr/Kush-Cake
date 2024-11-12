<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::all()->load(['user','address']);
        return Inertia::render('Admin/Orders/Index',[
            'orders' => $order
        ]);
    }

    public function show(Order $order)
    {
        return Inertia::render('Admin/Orders/Show',[
            'order' => $order->load(['orderItems.product.image','orderItems.product.category','orderItems.review','user','address', 'payments'])
        ]);
    }


}
