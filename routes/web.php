<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CustomizationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\StripeOrderController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomePageController::class,'index'])->name('welcome');
//get the auth user
Route::get('/user', function () {
    return response()->json(auth()->user());
})->name('user');
//order routes
Route::group(['middleware' => 'auth:sanctum', 'prefix'=>'order', 'as'=>'order.'], function () {
    Route::post('/order', [\App\Http\Controllers\OrderController::class,'store'])->name('store');
    Route::get('show/{order}', [\App\Http\Controllers\OrderController::class,'show'])->name('show');
    Route::get('/order', [\App\Http\Controllers\OrderController::class,'index'])->name('index');
    Route::post('/order/rating', [\App\Http\Controllers\OrderController::class,'rateOrderItem'])->name('rating');
    Route::get('/cart-count', [\App\Http\Controllers\OrderController::class,'orderItemCount'])->name('cart-count');
    Route::get('/cart', [\App\Http\Controllers\OrderController::class,'showCart'])->name('cart');
    Route::post('/update-order-item/{orderItem}', [\App\Http\Controllers\OrderController::class,'updateOrderItem'])->name('update_order_item');
    Route::put('/order/{order}', [\App\Http\Controllers\OrderController::class,'update'])->name('update');
    Route::get('/completeCheckout/{order}',[\App\Http\Controllers\OrderController::class,'checkout'])->name('complete_checkout');
    Route::delete('/order-item/{orderItem}', [\App\Http\Controllers\OrderController::class,'deleteOrderItem'])->name('remove_item');
});
//stripe payment routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/stripe/success/{order}', [StripeOrderController::class,'successCheckout'])->name('stripe_success');
    Route::get('/stripe/cancel', [StripeOrderController::class,'cancel'])->name('cancel');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix'=>'address', 'as'=>'address.'], function () {
    Route::post('/store', [AddressController::class,'store'])->name('store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomePageController::class,'index'])->name('dashboard');
//    Route::get('/dashboard', function () {
//        return Inertia::render('Dashboard');
//    })->name('dashboard');
});
//group the admin routes
Route::middleware(['auth:sanctum', 'verified'])
    ->prefix('admin')
    ->as('admin.')
    ->middleware(AdminMiddleware::class)
    ->group(function () {
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
        Route::delete('/review/delete', [ProductController::class,'deleteReview'])->name('review.delete');
    });
    //group customization routes
    Route::prefix('customization')->as('customization.')->group(function () {
        Route::get('/', [CustomizationController::class,'index'])->name('index');
        Route::post('/store', [CustomizationController::class,'store'])->name('store');
    });

    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/{order}', [OrderController::class,'show'])->name('show');
        Route::get('/', [OrderController::class,'index'])->name('index');
    });

    Route::prefix('payments')->as('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
        Route::get('/json', [PaymentController::class,'orderJson'])->name('json');
    });
});
