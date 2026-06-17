<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Products\CustomerProductController;
use App\Http\Controllers\Admin\Products\AdminProductController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Home route (This is the one Ziggy needs)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', function () {
    return Inertia::render('Cart');
})->name('cart');

// Search
Route::get('/search', function () {
    return Inertia::render('Search');
})->name('search');

// Product Routes
// Products - Using Customer Controller
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [CustomerProductController::class, 'show'])->name('products.show');
Route::get('/search', [CustomerProductController::class, 'search'])->name('products.search');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::patch('products/{id}/status', [AdminProductController::class, 'updateStatus'])->name('products.status');
});

// About & Contact Pages
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

require __DIR__.'/auth.php';
