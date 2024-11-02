<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StripeOrderController extends Controller
{
    public function checkout(Order $order)
    {
        //get the order items
        $orderItems = $order->orderItems()->get();
       dd($orderItems);
    }
}
