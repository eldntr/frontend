<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

use App\Http\Controllers\HomeController;
Route::get('/product', [HomeController::class, 'index'])->name('product.index');

use App\Http\Controllers\CartController;
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

use App\Http\Controllers\ProductController;
Route::resource('products', ProductController::class)->middleware('auth');

use App\Http\Controllers\CategoryController;
Route::resource('categories', CategoryController::class)->only(['store'])->middleware('auth');