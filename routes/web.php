<?php

use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\Products\CustomerProductController as CustomerProductController;
use App\Http\Controllers\Customer\CategoryController;
use App\Http\Controllers\Customer\BrandController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ============================================
// PUBLIC ROUTES
// ============================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::get('/about', fn() => Inertia::render('About'))->name('about');
Route::get('/contact', fn() => Inertia::render('Contact'))->name('contact');
Route::get('/faq', fn() => Inertia::render('FAQ'))->name('faq');
Route::get('/help', fn() => Inertia::render('Help'))->name('help');
Route::get('/deals', fn() => Inertia::render('StaticPage', [
    'title' => "Today's Deals",
    'description' => 'Fresh discounts and featured offers will appear here as soon as they are available.',
]))->name('deals');
Route::get('/sell', fn() => Inertia::render('StaticPage', [
    'title' => 'Sell on PakZone',
    'description' => 'Seller onboarding is coming soon. Contact support for marketplace partnership requests.',
]))->name('sell');
Route::get('/shipping', fn() => Inertia::render('StaticPage', [
    'title' => 'Shipping',
    'description' => 'Track delivery options, fees, and shipping timelines for PakZone orders.',
]))->name('shipping');
Route::get('/returns', fn() => Inertia::render('Returns'))->name('returns');
Route::get('/track', fn() => Inertia::render('Track'))->name('track');
Route::get('/payments', fn() => Inertia::render('StaticPage', [
    'title' => 'Payments',
    'description' => 'Secure payment options include cards, wallets, and cash-on-delivery where available.',
]))->name('payments');
Route::get('/cancellation', fn() => Inertia::render('StaticPage', [
    'title' => 'Cancellation',
    'description' => 'Order cancellation options are available before an order is packed or shipped.',
]))->name('cancellation');
Route::get('/gift-cards', fn() => Inertia::render('StaticPage', [
    'title' => 'Gift Cards',
    'description' => 'PakZone gift cards are not available yet. Check back for future gifting options.',
]))->name('gift-cards');

// Products
// Product Routes (ORDER MATTERS!)
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');

// Product detail - {slug} route MUST come AFTER /products
Route::get('/products/{slug}', [CustomerProductController::class, 'show'])->name('products.show');

// Search
Route::get('/search', [CustomerProductController::class, 'search'])->name('products.search');

// Categories
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Brands
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('brand.show');

// Cart - Guest can view
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// ============================================
// AUTH ROUTES (Laravel Breeze)
// ============================================
require __DIR__.'/auth.php';

// ============================================
// AUTHENTICATED CUSTOMER ROUTES
// ============================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => Inertia::render('Customers/Dashboard', [
        'user' => auth()->user(),
        'stats' => [
            'total_orders' => 0,
            'pending_orders' => 0,
            'total_spent' => 0,
            'wishlist_count' => 0
        ],
        'recentOrders' => []
    ]))->name('dashboard');

    // ============================================
    // CART ROUTES
    // ============================================
    Route::patch('/cart/{id}/save-for-later', [CartController::class, 'saveForLater'])->name('cart.save-for-later');
    Route::post('/cart/move-to-cart/{id}', [CartController::class, 'moveToCart'])->name('cart.move-to-cart');
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');

    // ============================================
    // CHECKOUT ROUTES
    // ============================================
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // ============================================
    // ORDER ROUTES
    // ============================================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // ============================================
    // WISHLIST ROUTES
    // ============================================
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{id}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

    // ============================================
    // PROFILE ROUTES
    // ============================================
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // ============================================
    // ADDRESS ROUTES
    // ============================================
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.default');

    // ============================================
    // REVIEW ROUTES
    // ============================================
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
