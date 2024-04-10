<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    // AUTH
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // PRODUCTS
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // SHOPS
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
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'getById'])->name('orders.getById');
    Route::get('/orders/user/{id}', [OrderController::class, 'getByUserId'])->name('orders.getByUser');

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // COMMENTS
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{id}', [CommentController::class, 'getById'])->name('comments.getById');
    Route::get('/comments/user/{id}', [CommentController::class, 'getByUserId'])->name('comments.getByUser');
    Route::get('/comments/product/{id}', [CommentController::class, 'getByProductId'])->name('comments.getByProduct');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');

    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// AUTH
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// PRODUCTS
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/products/sort', [ProductController::class, 'sort'])->name('products.sort');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'getById'])->name('products.getById');
Route::get('/products/search/{name}', [ProductController::class, 'search'])->name('products.search');

// SHOPS
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{id}', [ShopController::class, 'getById'])->name('shops.getById');
Route::get('/shops/user/{id}', [ShopController::class, 'getByUserId'])->name('shops.getByUser');
