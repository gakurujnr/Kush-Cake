<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

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
//        Route::get('/edit/{product}', [ProductController::class,'edit'])->name('edit');
        Route::put('/update/{product}', [ProductController::class,'update'])->name('update');
//        Route::delete('/delete/{product}', [ProductController::class,'destroy'])->name('delete');

        Route::post('/images/store', [ProductController::class,'storeImage'])->name('images.store');

    });
});
