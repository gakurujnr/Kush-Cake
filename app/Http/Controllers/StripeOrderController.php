<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StripeOrderController extends Controller
{
    public function successCheckout(Order $order)
    {
        $order->update([
            'status' => 'processing',
        ]);

        //create the payment record here
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->payment_amount = $order->total_amount;
        $payment->payment_method = 'credit_card';
        $payment->payment_date = now();
        $payment->payment_status = 'completed';
        $payment->save();

        return Inertia::render('Stripe/Success', [
            'order' => $order,
        ]);
    }

    public function cancel()
    {
        return Inertia::render('Stripe/Cancel');
    }
}
