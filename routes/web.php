<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ============================================
// PUBLIC PAGES
// ============================================

// Home
Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

// Static Pages
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/faq', function () {
    return Inertia::render('FAQ');
})->name('faq');

// ============================================
// PRODUCT ROUTES (Order matters!)
// ============================================


// 1. Products listing with real images
Route::get('/products', function () {
    // Real product images from Unsplash
    $products = [
        [
            'id' => 1,
            'name' => 'iPhone 15 Pro Max',
            'slug' => 'iphone-15-pro-max',
            'price' => 299999,
            'sale_price' => 269999,
            'discount_percentage' => 10,
            'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop',
            'brand' => 'Apple',
            'rating' => 4.8,
            'reviews_count' => 120,
            'sold_count' => 50,
            'stock' => 20,
            'best_seller' => true,
            'final_price' => 269999,
            'original_price' => 299999,
        ],
        [
            'id' => 2,
            'name' => 'Samsung Galaxy S24 Ultra',
            'slug' => 'samsung-galaxy-s24-ultra',
            'price' => 279999,
            'sale_price' => 249999,
            'discount_percentage' => 11,
            'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&h=400&fit=crop',
            'brand' => 'Samsung',
            'rating' => 4.7,
            'reviews_count' => 85,
            'sold_count' => 35,
            'stock' => 15,
            'best_seller' => false,
            'final_price' => 249999,
            'original_price' => 279999,
        ],
        [
            'id' => 3,
            'name' => 'Sony WH-1000XM5 Headphones',
            'slug' => 'sony-wh-1000xm5',
            'price' => 65000,
            'sale_price' => 59000,
            'discount_percentage' => 9,
            'image' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=400&h=400&fit=crop',
            'brand' => 'Sony',
            'rating' => 4.9,
            'reviews_count' => 45,
            'sold_count' => 20,
            'stock' => 10,
            'best_seller' => true,
            'final_price' => 59000,
            'original_price' => 65000,
        ],
        [
            'id' => 4,
            'name' => 'Nike Air Max 270',
            'slug' => 'nike-air-max-270',
            'price' => 22000,
            'sale_price' => null,
            'discount_percentage' => 0,
            'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
            'brand' => 'Nike',
            'rating' => 4.5,
            'reviews_count' => 30,
            'sold_count' => 60,
            'stock' => 25,
            'best_seller' => false,
            'final_price' => 22000,
            'original_price' => null,
        ],
        [
            'id' => 5,
            'name' => 'The Psychology of Money',
            'slug' => 'psychology-of-money',
            'price' => 1200,
            'sale_price' => 999,
            'discount_percentage' => 17,
            'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=400&fit=crop',
            'brand' => 'Harriman House',
            'rating' => 4.9,
            'reviews_count' => 200,
            'sold_count' => 100,
            'stock' => 50,
            'best_seller' => true,
            'final_price' => 999,
            'original_price' => 1200,
        ],
        [
            'id' => 6,
            'name' => 'Dell XPS 15 Laptop',
            'slug' => 'dell-xps-15',
            'price' => 350000,
            'sale_price' => 320000,
            'discount_percentage' => 8,
            'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&h=400&fit=crop',
            'brand' => 'Dell',
            'rating' => 4.6,
            'reviews_count' => 60,
            'sold_count' => 15,
            'stock' => 8,
            'best_seller' => false,
            'final_price' => 320000,
            'original_price' => 350000,
        ],
        [
            'id' => 7,
            'name' => 'Apple Watch Series 9',
            'slug' => 'apple-watch-series-9',
            'price' => 120000,
            'sale_price' => 109000,
            'discount_percentage' => 9,
            'image' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=400&h=400&fit=crop',
            'brand' => 'Apple',
            'rating' => 4.8,
            'reviews_count' => 90,
            'sold_count' => 40,
            'stock' => 18,
            'best_seller' => true,
            'final_price' => 109000,
            'original_price' => 120000,
        ],
        [
            'id' => 8,
            'name' => 'MacBook Pro 16"',
            'slug' => 'macbook-pro-16',
            'price' => 450000,
            'sale_price' => 420000,
            'discount_percentage' => 7,
            'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=400&fit=crop',
            'brand' => 'Apple',
            'rating' => 4.9,
            'reviews_count' => 150,
            'sold_count' => 25,
            'stock' => 12,
            'best_seller' => false,
            'final_price' => 420000,
            'original_price' => 450000,
        ],
        [
            'id' => 9,
            'name' => 'Adidas Ultraboost 22',
            'slug' => 'adidas-ultraboost-22',
            'price' => 28000,
            'sale_price' => 23000,
            'discount_percentage' => 18,
            'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=400&h=400&fit=crop',
            'brand' => 'Adidas',
            'rating' => 4.7,
            'reviews_count' => 55,
            'sold_count' => 45,
            'stock' => 30,
            'best_seller' => true,
            'final_price' => 23000,
            'original_price' => 28000,
        ],
        [
            'id' => 10,
            'name' => 'Samsung 4K Smart TV 55"',
            'slug' => 'samsung-4k-tv-55',
            'price' => 180000,
            'sale_price' => 165000,
            'discount_percentage' => 8,
            'image' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=400&h=400&fit=crop',
            'brand' => 'Samsung',
            'rating' => 4.6,
            'reviews_count' => 70,
            'sold_count' => 20,
            'stock' => 10,
            'best_seller' => false,
            'final_price' => 165000,
            'original_price' => 180000,
        ],
        [
            'id' => 11,
            'name' => 'Canon EOS R6 Camera',
            'slug' => 'canon-eos-r6',
            'price' => 350000,
            'sale_price' => 320000,
            'discount_percentage' => 9,
            'image' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=400&h=400&fit=crop',
            'brand' => 'Canon',
            'rating' => 4.9,
            'reviews_count' => 40,
            'sold_count' => 12,
            'stock' => 5,
            'best_seller' => false,
            'final_price' => 320000,
            'original_price' => 350000,
        ],
        [
            'id' => 12,
            'name' => 'The Lean Startup',
            'slug' => 'lean-startup-book',
            'price' => 1500,
            'sale_price' => 1200,
            'discount_percentage' => 20,
            'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=400&fit=crop',
            'brand' => 'Crown Business',
            'rating' => 4.8,
            'reviews_count' => 180,
            'sold_count' => 80,
            'stock' => 60,
            'best_seller' => true,
            'final_price' => 1200,
            'original_price' => 1500,
        ],
    ];

    return Inertia::render('Products/Index', [
        'products' => $products,
        'pagination' => [
            'current_page' => 1,
            'last_page' => 1,
        ],
        'categories' => [],
    ]);
})->name('products.index');

// 2. Product detail with real images
Route::get('/products/{slug}', function ($slug) {
    // Product images array
    $productImages = [
        'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&h=600&fit=crop',
        'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&h=600&fit=crop&crop=left',
        'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&h=600&fit=crop&crop=right',
        'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&h=600&fit=crop&crop=center',
    ];

    $product = [
        'id' => 1,
        'name' => 'iPhone 15 Pro Max',
        'slug' => $slug,
        'price' => 299999,
        'sale_price' => 269999,
        'discount_percentage' => 10,
        'description' => 'The ultimate iPhone with titanium design, A17 Pro chip, and 48MP camera. Features a 6.7-inch Super Retina XDR display with ProMotion and Always-On display. The new Action button replaces the mute switch for quick access to your favorite features.',
        'short_description' => 'A17 Pro chip, 48MP camera, Titanium design',
        'stock' => 20,
        'rating' => 4.8,
        'reviews_count' => 120,
        'images' => array_map(function($img) {
            return ['image' => $img];
        }, $productImages),
        'variants' => [
            ['id' => 1, 'type' => 'Color', 'value' => 'Natural Titanium'],
            ['id' => 2, 'type' => 'Color', 'value' => 'Blue Titanium'],
            ['id' => 3, 'type' => 'Color', 'value' => 'White Titanium'],
            ['id' => 4, 'type' => 'Storage', 'value' => '256GB'],
            ['id' => 5, 'type' => 'Storage', 'value' => '512GB'],
            ['id' => 6, 'type' => 'Storage', 'value' => '1TB'],
        ],
        'specifications' => [
            'Display' => '6.7-inch Super Retina XDR',
            'Processor' => 'A17 Pro chip',
            'Camera' => '48MP Main + 12MP Ultra Wide + 12MP Telephoto',
            'Battery' => 'Up to 29 hours video playback',
            'Storage' => '256GB, 512GB, 1TB',
            'Weight' => '221 grams',
        ],
        'reviews' => [
            [
                'id' => 1,
                'user' => ['name' => 'Ahmed Khan'],
                'rating' => 5,
                'comment' => 'Excellent phone! Best camera I\'ve ever used. The battery life is amazing and the display is stunning.',
                'created_at' => now()->subDays(2),
                'is_verified' => true,
            ],
            [
                'id' => 2,
                'user' => ['name' => 'Fatima Ali'],
                'rating' => 4,
                'comment' => 'Great phone but a bit expensive. The camera quality is outstanding though.',
                'created_at' => now()->subDays(5),
                'is_verified' => true,
            ],
            [
                'id' => 3,
                'user' => ['name' => 'Muhammad Usman'],
                'rating' => 5,
                'comment' => 'The best iPhone yet! The titanium build feels premium and the performance is incredible.',
                'created_at' => now()->subDays(7),
                'is_verified' => true,
            ],
        ],
        'brand' => ['name' => 'Apple'],
        'category' => ['name' => 'Electronics', 'slug' => 'electronics'],
        'best_seller' => true,
    ];

    // Related products with images
    $relatedProducts = [
        [
            'id' => 2,
            'name' => 'Samsung Galaxy S24 Ultra',
            'slug' => 'samsung-galaxy-s24-ultra',
            'price' => 279999,
            'sale_price' => 249999,
            'discount_percentage' => 11,
            'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=300&h=300&fit=crop',
            'brand' => 'Samsung',
            'rating' => 4.7,
            'reviews_count' => 85,
            'stock' => 15,
        ],
        [
            'id' => 3,
            'name' => 'Sony WH-1000XM5 Headphones',
            'slug' => 'sony-wh-1000xm5',
            'price' => 65000,
            'sale_price' => 59000,
            'discount_percentage' => 9,
            'image' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=300&h=300&fit=crop',
            'brand' => 'Sony',
            'rating' => 4.9,
            'reviews_count' => 45,
            'stock' => 10,
        ],
        [
            'id' => 4,
            'name' => 'Apple Watch Series 9',
            'slug' => 'apple-watch-series-9',
            'price' => 120000,
            'sale_price' => 109000,
            'discount_percentage' => 9,
            'image' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=300&h=300&fit=crop',
            'brand' => 'Apple',
            'rating' => 4.8,
            'reviews_count' => 90,
            'stock' => 18,
        ],
        [
            'id' => 5,
            'name' => 'MacBook Pro 16"',
            'slug' => 'macbook-pro-16',
            'price' => 450000,
            'sale_price' => 420000,
            'discount_percentage' => 7,
            'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=300&h=300&fit=crop',
            'brand' => 'Apple',
            'rating' => 4.9,
            'reviews_count' => 150,
            'stock' => 12,
        ],
    ];

    return Inertia::render('Products/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'user' => auth()->user(),
    ]);
})->name('products.show');

// 2. Product detail (MUST come AFTER the listing route)
Route::get('/products/{slug}', function ($slug) {
    // Sample product data
    $product = [
        'id' => 1,
        'name' => 'iPhone 15 Pro Max',
        'slug' => $slug,
        'price' => 299999,
        'sale_price' => 269999,
        'discount_percentage' => 10,
        'description' => 'The ultimate iPhone with titanium design, A17 Pro chip, and 48MP camera. Features a 6.7-inch Super Retina XDR display with ProMotion and Always-On display.',
        'short_description' => 'A17 Pro chip, 48MP camera, Titanium design',
        'stock' => 20,
        'rating' => 4.8,
        'reviews_count' => 120,
        'images' => [
            ['image' => 'https://via.placeholder.com/600x600?text=iPhone+15+Main'],
            ['image' => 'https://via.placeholder.com/600x600?text=iPhone+15+Back'],
            ['image' => 'https://via.placeholder.com/600x600?text=iPhone+15+Side'],
        ],
        'variants' => [
            ['id' => 1, 'type' => 'Color', 'value' => 'Silver'],
            ['id' => 2, 'type' => 'Color', 'value' => 'Gold'],
            ['id' => 3, 'type' => 'Storage', 'value' => '256GB'],
            ['id' => 4, 'type' => 'Storage', 'value' => '512GB'],
        ],
        'reviews' => [
            [
                'id' => 1,
                'user' => ['name' => 'Ahmed Khan'],
                'rating' => 5,
                'comment' => 'Excellent phone! Best camera I\'ve ever used.',
                'created_at' => now()->subDays(2),
                'is_verified' => true,
            ],
            [
                'id' => 2,
                'user' => ['name' => 'Fatima Ali'],
                'rating' => 4,
                'comment' => 'Great phone but a bit expensive.',
                'created_at' => now()->subDays(5),
                'is_verified' => true,
            ],
        ],
        'brand' => ['name' => 'Apple'],
        'category' => ['name' => 'Electronics', 'slug' => 'electronics'],
        'best_seller' => true,
    ];

    $relatedProducts = [
        [
            'id' => 2,
            'name' => 'Samsung Galaxy S24 Ultra',
            'slug' => 'samsung-galaxy-s24-ultra',
            'price' => 279999,
            'sale_price' => 249999,
            'discount_percentage' => 11,
            'image' => 'https://via.placeholder.com/300x300?text=Samsung+S24',
            'brand' => 'Samsung',
            'rating' => 4.7,
            'reviews_count' => 85,
            'stock' => 15,
        ],
        [
            'id' => 3,
            'name' => 'Sony WH-1000XM5',
            'slug' => 'sony-wh-1000xm5',
            'price' => 65000,
            'sale_price' => 59000,
            'discount_percentage' => 9,
            'image' => 'https://via.placeholder.com/300x300?text=Sony+Headphones',
            'brand' => 'Sony',
            'rating' => 4.9,
            'reviews_count' => 45,
            'stock' => 10,
        ],
    ];

    return Inertia::render('Products/Show', [
        'product' => $product,
        'relatedProducts' => $relatedProducts,
        'user' => auth()->user(),
    ]);
})->name('products.show');

// Search
Route::get('/search', function () {
    return Inertia::render('Search', [
        'query' => request('q', ''),
        'products' => []
    ]);
})->name('search');

// ============================================
// CATEGORY & BRAND ROUTES
// ============================================

Route::get('/category/{slug}', function ($slug) {
    return Inertia::render('Categories/Show', [
        'category' => [
            'id' => 1,
            'name' => ucfirst($slug),
            'slug' => $slug,
            'description' => 'Category description',
            'icon' => '📱',
        ],
        'subCategories' => [],
        'products' => []
    ]);
})->name('category.show');

Route::get('/brand/{slug}', function ($slug) {
    return Inertia::render('Brands/Show', [
        'brand' => [
            'id' => 1,
            'name' => ucfirst($slug),
            'slug' => $slug,
            'logo' => null,
            'description' => 'Brand description',
            'website' => null,
        ],
        'products' => []
    ]);
})->name('brand.show');

// ============================================
// CART & CHECKOUT
// ============================================

Route::get('/cart', function () {
    return Inertia::render('Cart/Index', [
        'cartItems' => [],
        'savedItems' => [],
        'subtotal' => 0,
        'shippingCost' => 0,
        'discount' => 0,
        'tax' => 0,
        'total' => 0
    ]);
})->name('cart.index');

Route::get('/checkout', function () {
    return Inertia::render('Cart/Checkout', [
        'cartItems' => [],
        'addresses' => [],
        'subtotal' => 0,
        'shippingCost' => 0,
        'discount' => 0,
        'tax' => 0,
        'total' => 0,
        'user' => null
    ]);
})->name('checkout');

// ============================================
// WISHLIST
// ============================================

Route::get('/wishlist', function () {
    return Inertia::render('Customers/Wishlist/Index', [
        'wishlist' => []
    ]);
})->name('wishlist.index');

// ============================================
// AUTH ROUTES (Laravel Breeze)
// ============================================

require __DIR__.'/auth.php';

// ============================================
// AUTHENTICATED CUSTOMER PAGES
// ============================================

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Customers/Dashboard', [
            'user' => auth()->user(),
            'stats' => [
                'total_orders' => 0,
                'pending_orders' => 0,
                'total_spent' => 0,
                'wishlist_count' => 0
            ],
            'recentOrders' => []
        ]);
    })->name('dashboard');

    // Profile
    Route::get('/profile', function () {
        return Inertia::render('Customers/Profile/Index', [
            'user' => auth()->user(),
            'stats' => [
                'total_orders' => 0,
                'total_spent' => 0,
                'wishlist_count' => 0
            ],
            'recentOrders' => []
        ]);
    })->name('profile.index');

    Route::get('/profile/edit', function () {
        return Inertia::render('Customers/Profile/Edit', [
            'user' => auth()->user()
        ]);
    })->name('profile.edit');

    Route::get('/profile/change-password', function () {
        return Inertia::render('Customers/Profile/ChangePassword');
    })->name('profile.change-password');

    // Orders
    Route::get('/orders', function () {
        return Inertia::render('Customers/Orders/Index', [
            'orders' => []
        ]);
    })->name('orders.index');

    Route::get('/orders/{id}', function ($id) {
        return Inertia::render('Customers/Orders/Show', [
            'order' => [
                'id' => $id,
                'order_number' => 'PAK-2026-001',
                'created_at' => now(),
                'total_amount' => 1500,
                'subtotal' => 1200,
                'shipping_cost' => 150,
                'tax_amount' => 150,
                'discount' => 0,
                'status' => 'pending',
                'items' => [],
                'shipping_address' => null
            ],
            'taxRate' => 17
        ]);
    })->name('orders.show');

    Route::get('/orders/{id}/track', function ($id) {
        return Inertia::render('Customers/Orders/Track', [
            'order' => [
                'id' => $id,
                'order_number' => 'PAK-2026-001',
                'created_at' => now(),
                'status' => 'shipped',
                'tracking_number' => 'TRK123456',
                'shipping_method' => 'Standard'
            ]
        ]);
    })->name('orders.track');

    // Addresses
    Route::get('/addresses', function () {
        return Inertia::render('Customers/Addresses/Index', [
            'addresses' => []
        ]);
    })->name('addresses.index');

    Route::get('/addresses/create', function () {
        return Inertia::render('Customers/Addresses/Create');
    })->name('addresses.create');

    Route::get('/addresses/{id}/edit', function ($id) {
        return Inertia::render('Customers/Addresses/Edit', [
            'address' => [
                'id' => $id,
                'name' => '',
                'phone' => '',
                'address' => '',
                'city' => '',
                'state' => '',
                'country' => 'Pakistan',
                'pincode' => '',
                'type' => 'shipping',
                'is_default' => false
            ]
        ]);
    })->name('addresses.edit');

    // Reviews
    Route::get('/reviews', function () {
        return Inertia::render('Customers/Reviews/Index', [
            'reviews' => [],
            'stats' => [
                'total' => 0,
                'approved' => 0,
                'pending' => 0,
                'average_rating' => 0
            ]
        ]);
    })->name('reviews.index');

    Route::get('/reviews/create', function () {
        return Inertia::render('Customers/Reviews/Create', [
            'product' => [
                'id' => 1,
                'name' => 'Sample Product',
                'image' => null
            ],
            'order_number' => 'PAK-2026-001'
        ]);
    })->name('reviews.create');
});

// ============================================
// ADMIN PAGES
// ============================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard/Index', [
            'stats' => [
                'revenue' => 0,
                'orders' => 0,
                'products' => 0,
                'users' => 0
            ],
            'recentOrders' => [],
            'lowStockProducts' => []
        ]);
    })->name('dashboard');

    // Products
    Route::get('/products', function () {
        return Inertia::render('Admin/Products/Index', [
            'products' => [],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1
            ]
        ]);
    })->name('products.index');

    Route::get('/products/create', function () {
        return Inertia::render('Admin/Products/Create', [
            'categories' => [],
            'brands' => []
        ]);
    })->name('products.create');

    Route::get('/products/{id}/edit', function ($id) {
        return Inertia::render('Admin/Products/Edit', [
            'product' => [
                'id' => $id,
                'name' => 'Sample Product',
                'sku' => 'SKU001',
                'category_id' => 1,
                'brand_id' => 1,
                'price' => 999,
                'sale_price' => null,
                'stock' => 10,
                'status' => 'draft',
                'featured' => false,
                'best_seller' => false,
                'short_description' => '',
                'description' => ''
            ],
            'categories' => [],
            'brands' => []
        ]);
    })->name('products.edit');

    // Categories
    Route::get('/categories', function () {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => [],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1
            ]
        ]);
    })->name('categories.index');

    Route::get('/categories/create', function () {
        return Inertia::render('Admin/Categories/Create', [
            'categories' => []
        ]);
    })->name('categories.create');

    Route::get('/categories/{id}/edit', function ($id) {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => [
                'id' => $id,
                'name' => 'Sample Category',
                'slug' => 'sample-category',
                'description' => '',
                'parent_id' => null,
                'icon' => '',
                'is_active' => true,
                'sort_order' => 0
            ],
            'categories' => []
        ]);
    })->name('categories.edit');

    // Brands
    Route::get('/brands', function () {
        return Inertia::render('Admin/Brands/Index', [
            'brands' => []
        ]);
    })->name('brands.index');

    Route::get('/brands/create', function () {
        return Inertia::render('Admin/Brands/Create');
    })->name('brands.create');

    Route::get('/brands/{id}/edit', function ($id) {
        return Inertia::render('Admin/Brands/Edit', [
            'brand' => [
                'id' => $id,
                'name' => 'Sample Brand',
                'slug' => 'sample-brand',
                'logo' => null,
                'description' => '',
                'website' => '',
                'is_featured' => false,
                'is_active' => true
            ]
        ]);
    })->name('brands.edit');

    // Orders
    Route::get('/orders', function () {
        return Inertia::render('Admin/Orders/Index', [
            'orders' => [],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1
            ]
        ]);
    })->name('orders.index');

    Route::get('/orders/{id}', function ($id) {
        return Inertia::render('Admin/Orders/Show', [
            'order' => [
                'id' => $id,
                'order_number' => 'PAK-2026-001',
                'created_at' => now(),
                'total_amount' => 1500,
                'subtotal' => 1200,
                'shipping_cost' => 150,
                'tax_amount' => 150,
                'discount' => 0,
                'status' => 'pending',
                'items' => [],
                'user' => null,
                'shipping_address' => null
            ]
        ]);
    })->name('orders.show');

    // Users
    Route::get('/users', function () {
        return Inertia::render('Admin/Users/Index', [
            'users' => [],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1
            ]
        ]);
    })->name('users.index');

    Route::get('/users/{id}', function ($id) {
        return Inertia::render('Admin/Users/Show', [
            'user' => [
                'id' => $id,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '03001234567',
                'status' => 'active',
                'created_at' => now(),
                'role' => ['name' => 'customer']
            ]
        ]);
    })->name('users.show');

    // Coupons
    Route::get('/coupons', function () {
        return Inertia::render('Admin/Coupons/Index', [
            'coupons' => [],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1
            ]
        ]);
    })->name('coupons.index');

    Route::get('/coupons/create', function () {
        return Inertia::render('Admin/Coupons/Create');
    })->name('coupons.create');

    Route::get('/coupons/{id}/edit', function ($id) {
        return Inertia::render('Admin/Coupons/Edit', [
            'coupon' => [
                'id' => $id,
                'code' => 'SUMMER20',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 0,
                'max_discount' => null,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'applies_to' => 'all',
                'is_active' => true
            ]
        ]);
    })->name('coupons.edit');

    // Reports
    Route::get('/reports/sales', function () {
        return Inertia::render('Admin/Reports/Sales', [
            'report' => [
                'total_sales' => 0,
                'total_orders' => 0,
                'average_order' => 0,
                'total_customers' => 0,
                'data' => []
            ]
        ]);
    })->name('reports.sales');

    Route::get('/reports/products', function () {
        return Inertia::render('Admin/Reports/Products');
    })->name('reports.products');

    Route::get('/reports/users', function () {
        return Inertia::render('Admin/Reports/Users');
    })->name('reports.users');
});
// ============================================
// FOOTER PAGES
// ============================================

Route::get('/track', function () {
    return Inertia::render('Track');
})->name('track');

Route::get('/returns', function () {
    return Inertia::render('Returns');
})->name('returns');

Route::get('/faq', function () {
    return Inertia::render('FAQ');
})->name('faq');

Route::get('/help', function () {
    return Inertia::render('Help');
})->name('help');

Route::get('/deals', function () {
    return Inertia::render('Deals');
})->name('deals');

Route::get('/sell', function () {
    return Inertia::render('Sell');
})->name('sell');

Route::get('/shipping', function () {
    return Inertia::render('Shipping');
})->name('shipping');

Route::get('/gift-cards', function () {
    return Inertia::render('GiftCards');
})->name('gift-cards');

Route::get('/payments', function () {
    return Inertia::render('Payments');
})->name('payments');

Route::get('/cancellation', function () {
    return Inertia::render('Cancellation');
})->name('cancellation');

Route::get('/report', function () {
    return Inertia::render('Report');
})->name('report');
