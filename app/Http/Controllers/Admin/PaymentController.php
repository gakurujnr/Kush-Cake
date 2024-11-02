<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Payments/Index',[
            'payments'=>Payment::all()->load('order')
        ]);
    }
       public function orderJson(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'orders'=>Order::all()
        ]);
    }
    public function store(Request $request)
    {
        $payment = new Payment();
        $payment->order_id = $request->order_id;
        $payment->payment_amount = $request->payment_amount;
        $payment->payment_method = $request->payment_method;
        $payment->payment_date = $request->payment_date;
        $payment->payment_status = $request->payment_status;
        $payment->save();

        $order = Order::query()->find($request->order_id);
        $order->status = 'processing';
        $order->save();

        return to_route('admin.payments.index');
    }
}
