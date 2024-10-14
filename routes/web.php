<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\SellerDashboardController;

Route::get('/', function () {
    return redirect()->route('product.index');
});

Route::get('/productoverview', function () {
    return view('productoverview');
});

Route::get('/users/profile', function () {
    return view('users.profile');
});


// User Routes
Route::resource('users', UserController::class);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Home/Product Routes
Route::get('/', [HomeController::class, 'index'])->name('product.index');
Route::post('/category/{id}', [HomeController::class, 'categoryFilter'])->name('product.filter');

// Product Routes
Route::resource('products', ProductController::class)->middleware('auth');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products/search', [ProductController::class, 'search'])->name('product.search');


// Category Routes
Route::resource('categories', CategoryController::class)->only(['store'])->middleware('auth');


// Transaction Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    // Cart Routes
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/increment/{id}', [CartController::class, 'incrementQuantity'])->name('cart.incrementQuantity');
    Route::post('/cart/update/decrement/{id}', [CartController::class, 'decrementQuantity'])->name('cart.decrementQuantity');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/checkout', [TransactionController::class, 'createOrder'])->name('checkout');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Seller Dashboard Routes
    Route::get('/seller/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
    Route::post('/seller/product/{id}/discount', [ProductController::class, 'setDiscount'])->name('seller.product.discount');
    Route::get('/seller/orders', [TransactionController::class, 'listOrders'])->name('seller.orders');
    Route::post('/seller/product/{id}/stock', [ProductController::class, 'manageStock'])->name('seller.product.stock');

    // Review Routes
    Route::post('products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Discussion Routes
    Route::post('products/{product}/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::post('discussions/{discussion}/reply', [DiscussionController::class, 'reply'])->name('discussions.reply');
});

// Payment routes
Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/process/{order}', [PaymentController::class, 'process'])->name('payment.process');

// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/move-to-cart/{product}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
Route::post('/payment/complete/{order}', [PaymentController::class, 'complete'])->name('payment.complete');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/orders/{id}/mark-as-shipped', [TransactionController::class, 'markAsShipped'])->name('orders.markAsShipped');
