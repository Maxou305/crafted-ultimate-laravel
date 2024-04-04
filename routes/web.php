<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// PRODUCTS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'getById'])->name('products.getById');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// SHOPS

Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
