<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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
        } else {
            return response()->json(['count' => 0]);
        }
    }

    public function showCart()
    {
        $order = Order::query()->where('user_id', auth()->id())->where('status', 'pending')->first();
        return Inertia::render('Cart/Index', [
            'order_prop' => $this->cartFullOrder(),
            'cart_count' => $order ? $order->orderItems()->count() : 0,
            'addresses' => auth()->user()->addresses()->get(),
            'stripe_key' => config('cashier.key')
        ]);
    }

    private function cartFullOrder()
    {
        return Order::query()
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first()
            ->load(['orderItems.product.image', 'orderItems.product.category']);
    }

    public function updateOrderItem(OrderItem $orderItem, Request $request)
    {
        if ($request->has('quantity')) {
            $orderItem->quantity = $request->quantity;
            $orderItem->save();
        }

        return response()->json([
            'message' => 'Order item updated successfully',
            'order' => $this->cartFullOrder()
        ]);
    }

    public function update(Order $order, Request $request)
    {
        if ($request->has('address_id')) {
            $order->address_id = $request->address_id;
            $order->save();
        }

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $this->cartFullOrder()
        ]);
    }

    public function checkout(Order $order)
    {
        //compute the total amount of the order based on the order items quantity and price
        /* $totalAmount = $order->orderItems->sum(function ($orderItem){
             return $orderItem->quantity * $orderItem->price;
         });
         $order->update([
             'total_amount' => $totalAmount,
         ]);*/

        $lineItems = [];
        $order->orderItems()->get()->load('product')->each(function ($orderItem) use (&$lineItems) {
            $lineItems[] = [
                'price' => $orderItem->product->stripe_price_id,
                'quantity' => $orderItem->quantity,
            ];
        });
        //initalize stripe code here
//
        // Set Stripe API key using Laravel Cashier's configured key
        Stripe::setApiKey(config('cashier.secret'));

        // Create a Stripe Checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->id, // Attach order ID here
            ],
            'success_url' => route('stripe_success',['order'=>$order->id]), // Define your success route
            'cancel_url' => route('cancel'),   // Define your cancel route
        ]);

        return response()->json([
            'message' => 'Order checked out successfully',
            'order' => $order,
            'stripe_session_id' => $session->id
        ]);
    }

    public function index()
    {
        $cartOrder = Order::query()->where('user_id', auth()->id())->where('status', 'pending')->first();

        return Inertia::render('Order/Index', [
            'orders' => Order::query()->where('user_id', auth()->user()->id)->get()->load(['user', 'address']),
            'cart_count' => $cartOrder ? $cartOrder->orderItems()->count() : 0
        ]);
    }

    public function show(Order $order)
    {
        $cartOrder = Order::query()->where('user_id', auth()->id())->where('status', 'pending')->first();
        return Inertia::render('Order/Show', [
            'order' => $order->load(['orderItems.product.image', 'orderItems.product.category', 'orderItems.review', 'user', 'address', 'payments']),
            'cart_count' => $cartOrder ? $cartOrder->orderItems()->count() : 0,
        ]);
    }

    public function rateOrderItem(Request $request)
    {
        //get the order item
        $orderItem = OrderItem::query()->find($request->order_item_id)->load('product');

        $review = new Review();
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->order_item_id = $orderItem->id;
        $review->product_id = $orderItem->product->id;
        $review->user_id = auth()->id();
        $review->save();

        return to_route('order.show', $orderItem->order_id);
    }

    public function deleteOrderItem(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json([
            'message' => 'Order item deleted successfully',
            'order' => $this->cartFullOrder()
        ]);
    }
}
