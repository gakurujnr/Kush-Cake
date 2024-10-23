<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        //first check if the user has an active order record
        $product = Product::query()->find($request->product_id);
        $order = Order::query()->where('user_id', auth()->id())->where('status', 'pending')->first();
       //make this a transaction
           DB::beginTransaction();
           if ($order) {
               $order->update([
                   'total_amount' => $order->total_amount + $product->price,
               ]);
           } else {
               $order = Order::query()->create([
                   'user_id' => auth()->id(),
                   'total_amount' => $product->price,
               ]);
           }
           //add the order item by first checking if the order item exist in which case, add the quantity, else create the order item
           $orderItem = $order->orderItems()->where('product_id', $product->id)->first();
           if ($orderItem) {
               $orderItem->update([
                   'quantity' => $orderItem->quantity + 1,
               ]);
           } else {
               $order->orderItems()->create([
                   'product_id' => $product->id,
                   'quantity' => 1,
                   'price' => $product->price,
                   'order_id' => $order->id,
               ]);
           }

           //reduce the product quantity
           $product->stock = $product->stock - 1;
           $product->save();

           DB::commit();
        return to_route('welcome');
    }

    public function orderItemCount(): \Illuminate\Http\JsonResponse
    {
        //get current order then count the order items
        $order = Order::query()->where('user_id', auth()->id())->where('status', 'pending')->first();
        if ($order) {
            return response()->json(['count' => $order->orderItems()->count()]);
        }else{
            return response()->json(['count' => 0]);
        }
    }

    public function showCart()
    {
        $order = Order::query()->where('user_id', auth()->id())->where('status', 'pending')->first();
        return Inertia::render('Cart/Index',[
            'order' => $this->cartFullOrder(),
            'cart_count' => $order ? $order->orderItems()->count() : 0,
            'addresses'=>auth()->user()->addresses()->get()
        ]);
    }
    private function cartFullOrder()
    {
        return Order::query()
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->first()
                ->load(['orderItems.product.image','orderItems.product.category']);
    }
    public function updateOrderItem(OrderItem $orderItem, Request $request)
    {
        if ($request->has('quantity')){
            $orderItem->quantity = $request->quantity;
            $orderItem->save();
        }

        return response()->json([
            'message' => 'Order item updated successfully',
            'order'=> $this->cartFullOrder()
        ]);
    }
}
