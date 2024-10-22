<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomizationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\HomePageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomePageController::class,'index'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
//group the admin routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('/users', [UsersController::class,'index'])->name('users');
    Route::get('/categories', [CategoriesController::class,'index'])->name('categories');
    Route::post('/store-categories', [CategoriesController::class,'store'])->name('categories.store');

    //group the product routes
    Route::prefix('products')->as('products.')->prefix('products')->group(function () {
        Route::get('/', [ProductController::class,'index'])->name('index');
        Route::post('/store', [ProductController::class,'store'])->name('store');
        Route::put('/update/{product}', [ProductController::class,'update'])->name('update');
        Route::post('/images/store', [ProductController::class,'storeImage'])->name('images.store');
    });
    //group customization routes
    Route::prefix('customization')->as('customization.')->group(function () {
        Route::get('/', [CustomizationController::class,'index'])->name('index');
        Route::post('/store', [CustomizationController::class,'store'])->name('store');
    });

    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/', [OrderController::class,'index'])->name('index');
        Route::get('/{order}', [OrderController::class,'show'])->name('show');
//        Route::put('/update/{order}', [OrderController::class,'update'])->name('update');
    });

    Route::prefix('payments')->as('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
    });

    Route::prefix('reviews')->as('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
    });
});
