<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController as UserDashboardController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/books/{book:slug}', [BookController::class, 'show'])->name('books.show');
Route::post('/books/{book:slug}/reviews', [BookController::class, 'storeReview'])->middleware(['auth', 'customer'])->name('books.reviews.store');

Route::get('/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest')->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'customer'])->group(function () {
    // Authenticated customer pages
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/promo', [UserDashboardController::class, 'promos'])->name('promo');
    Route::get('/orders', [UserDashboardController::class, 'ordersPage'])->name('orders');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/apply-promo', [CartController::class, 'applyPromo'])->name('cart.apply_promo');
    Route::post('/cart/remove-promo', [CartController::class, 'removePromo'])->name('cart.remove_promo');
    Route::post('/cart/{book}/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{book}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/wishlist/{book}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Checkout AJAX helpers
    Route::post('/checkout/apply-promo', [CheckoutController::class, 'applyPromo'])->name('checkout.apply_promo');
    Route::post('/checkout/remove-promo', [CheckoutController::class, 'removePromo'])->name('checkout.remove_promo');
    Route::get('/checkout/cities', [CheckoutController::class, 'getCities'])->name('checkout.cities');
    Route::get('/checkout/districts', [CheckoutController::class, 'getDistricts'])->name('checkout.districts');
    Route::get('/checkout/shipping', [CheckoutController::class, 'getShipping'])->name('checkout.shipping');
    Route::get('/checkout/payment-status/{order}', [CheckoutController::class, 'checkPayment'])->name('checkout.payment_status');
    Route::post('/checkout/pay/{order}', [CheckoutController::class, 'simulatePayment'])->name('checkout.simulate_payment');
    Route::post('/orders/{order}/complete', [UserDashboardController::class, 'completeOrder'])->name('orders.complete');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', AdminBookController::class)->except(['show']);
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('promos', AdminPromoController::class)->except(['show']);
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
});
