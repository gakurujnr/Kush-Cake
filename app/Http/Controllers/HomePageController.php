<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomePageController extends Controller
{
        public function index()
    {
        $products = Product::all()->load(['category','image', 'reviews.user']);
         return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
        'products' => $products
    ]);
    }
}
