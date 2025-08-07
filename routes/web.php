<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductPriceController;

Route::get('/', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {

        // Category Routes
        Route::get('admin/categories/{id}/subcategories', [CategoryController::class, 'getSubcategories']);
        Route::post('/categories/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('{id}/subcategories', [CategoryController::class, 'getSubcategories']);
            Route::get('/index', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        });

        // Brand Routes
        Route::post('brands/toggle-status', action: [BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
        Route::prefix('brands')->name('brands.')->group(function () {
            Route::get('/index', [BrandController::class, 'index'])->name('index');
            Route::get('/create', [BrandController::class, 'create'])->name('create');
            Route::post('/store', [BrandController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BrandController::class, 'update'])->name('update'); // Changed from /{id}/update
            Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
        });

        // Product Routes
        Route::post('/products/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        });

        // User Routes
                Route::post('/users/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Product Prices
        Route::prefix('product-prices')->name('product-prices.')->group(function () {
            Route::get('/', [ProductPriceController::class, 'index'])->name('index');
            Route::get('/create', [ProductPriceController::class, 'create'])->name('create');
            Route::post('/', [ProductPriceController::class, 'store'])->name('store');
            Route::get('/{id}', [ProductPriceController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ProductPriceController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductPriceController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductPriceController::class, 'destroy'])->name('destroy');
        });

    });

});

require __DIR__ . '/auth.php';
