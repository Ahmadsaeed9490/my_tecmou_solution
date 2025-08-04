<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductPriceController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home'); })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::prefix('admin')->group(function () {
    Route::post('/categories/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
});
    Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
        Route::get('admin/categories/{id}/subcategories', [CategoryController::class, 'getSubcategories']);
        Route::get('/index', [CategoryController::class, 'index'])->name('index');         // List categories
        Route::get('/create', [CategoryController::class, 'create'])->name('create'); // Show create form
        Route::post('/store', [CategoryController::class, 'store'])->name('store');        // Store category
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');       // Show single category
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');


    });
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('brands', BrandController::class);
    Route::post('/brands/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
});
   Route::prefix('admin/brands')->name('admin.brands.')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('index');
    Route::get('/create', [BrandController::class, 'create'])->name('create');
    Route::post('/store', [BrandController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BrandController::class, 'update'])->name('update');
    Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
});
Route::post('products/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');


    Route::prefix('admin/products')->name('admin.products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
Route::prefix('admin')->group(function () {
    Route::post('/users/toggle-status', [userController::class, 'toggleStatus'])->name('users.toggleStatus');
});

Route::prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); // ✅ Corrected
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('product-prices', [ProductPriceController::class, 'index'])->name('product-prices.index');
    Route::get('product-prices/create', [ProductPriceController::class, 'create'])->name('product-prices.create');
    Route::post('product-prices', [ProductPriceController::class, 'store'])->name('product-prices.store');
    Route::get('product-prices/{id}', [ProductPriceController::class, 'show'])->name('product-prices.show');
    Route::get('product-prices/{id}/edit', [ProductPriceController::class, 'edit'])->name('product-prices.edit');
    Route::put('product-prices/{id}', [ProductPriceController::class, 'update'])->name('product-prices.update');
    Route::delete('product-prices/{id}', [ProductPriceController::class, 'destroy'])->name('product-prices.destroy');
});




});

require __DIR__ . '/auth.php';
