<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf', function () {
    return csrf_token();
});

// PRODUCTS
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'getById'])->name('products.getById');
Route::get('/products/category/{category}', [ProductController::class, 'getByCategory'])->name('products.getByCategory');

Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// SHOPS
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{id}', [ShopController::class, 'getById'])->name('shops.getById');
Route::get('/shops/user/{id}', [ShopController::class, 'getByUserId'])->name('shops.getByUser');

Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

Route::put('/shops/{id}', [ShopController::class, 'update'])->name('shops.update');

Route::delete('/shops/{id}', [ShopController::class, 'destroy'])->name('shops.destroy');

// USERS
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'getById'])->name('users.getById');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// ORDERS

// ORDER PRODUCTS

// COMMENTS
