<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->load(['category','image']);

        return Inertia::render('Admin/Products/Index',[
            'categories' => Category::all(),
            'products' =>$products
        ]);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        //generate random number for the product that starts with 250
        $product->slug = '250'.rand(1000,99999);
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
}
