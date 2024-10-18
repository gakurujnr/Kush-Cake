<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index',[
            'categories' => Category::all(),
            'products' => Product::all()->load('category')
        ]);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->slug = \Str::slug($request->name);
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
}
