<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Stripe;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->load(['category','image','reviews']);

        return Inertia::render('Admin/Products/Index',[
            'categories' => Category::all(),
            'products' =>$products
        ]);
    }

    public function store(Request $request)
    {
        Stripe::setApiKey(config('cashier.secret'));

        $stripeProduct =\Stripe\Product::create([
            'name' => $request->name,
            'description'  => $request->description,
        ]);
        $stripePrice = \Stripe\Price::create([
            'unit_amount' => $request->price * 100,
            'currency' => 'usd',
            'product' => $stripeProduct->id,
        ]);
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        //generate random number for the product that starts with 250
        $product->slug = '250'.rand(1000,99999);
        $product->stripe_product_id = $stripeProduct->id;
        $product->stripe_price_id = $stripePrice->id;
        $product->save();

        return to_route('admin.products.index');
    }

    public function update(Product $product, Request $request)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->save();

        return to_route('admin.products.index');
    }

    public function storeImage(Request $request)
    {
        //save the image
        $path = $request->file('avatar')->storePublicly('products');
        //remove all the images that are not the current image
        ProductImage::query()->where('product_id', $request->product_id)->delete();

//        save the image path to the database
        $image = new ProductImage();
        $image->image_url = $path;
        $image->product_id = $request->product_id;
        $image->save();

        return to_route('admin.products.index');
    }

    public function deleteReview(Request $request)
    {
        Review::query()->find($request->review_id)->delete();
        return to_route('admin.products.index');
    }
}
