<?php

namespace Database\Seeders;

use App\Models\Products\Category;
use App\Models\Products\Brand;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // ============================================
        // 1. CREATE OR UPDATE CATEGORIES
        // ============================================
        $electronics = Category::updateOrCreate(
            ['slug' => 'electronics'],
            [
                'name' => 'Electronics',
                'description' => 'Latest electronics and gadgets',
                'is_active' => true,
                'sort_order' => 1
            ]
        );

        $fashion = Category::updateOrCreate(
            ['slug' => 'fashion'],
            [
                'name' => 'Fashion',
                'description' => 'Trendy fashion for men and women',
                'is_active' => true,
                'sort_order' => 2
            ]
        );

        $home = Category::updateOrCreate(
            ['slug' => 'home-kitchen'],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Everything for your home',
                'is_active' => true,
                'sort_order' => 3
            ]
        );

        // ============================================
        // 2. CREATE OR UPDATE BRANDS
        // ============================================
        $apple = Brand::updateOrCreate(
            ['slug' => 'apple'],
            [
                'name' => 'Apple',
                'is_featured' => true,
                'is_active' => true
            ]
        );

        $samsung = Brand::updateOrCreate(
            ['slug' => 'samsung'],
            [
                'name' => 'Samsung',
                'is_featured' => true,
                'is_active' => true
            ]
        );

        $sony = Brand::updateOrCreate(
            ['slug' => 'sony'],
            [
                'name' => 'Sony',
                'is_featured' => true,
                'is_active' => true
            ]
        );

        $nike = Brand::updateOrCreate(
            ['slug' => 'nike'],
            [
                'name' => 'Nike',
                'is_featured' => true,
                'is_active' => true
            ]
        );

        // ============================================
        // 3. CREATE OR UPDATE PRODUCTS
        // ============================================
        $product1 = Product::updateOrCreate(
            ['slug' => 'iphone-15-pro-max'],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'The ultimate iPhone with titanium design, A17 Pro chip, and 48MP camera. Features a 6.7-inch Super Retina XDR display with ProMotion and Always-On display.',
                'short_description' => 'A17 Pro chip, 48MP camera, Titanium design',
                'price' => 299999,
                'sale_price' => 269999,
                'sku' => 'APP-IP15PM-001',
                'stock' => 50,
                'category_id' => $electronics->id,
                'brand_id' => $apple->id,
                'featured' => true,
                'best_seller' => true,
                'status' => 'published',
                'rating' => 4.8,
                'reviews_count' => 120
            ]
        );

        $product2 = Product::updateOrCreate(
            ['slug' => 'samsung-galaxy-s24-ultra'],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Experience the power of Galaxy AI with S24 Ultra. Features a 6.8-inch Dynamic AMOLED 2X display, 200MP camera, and S Pen.',
                'short_description' => 'Galaxy AI, 200MP camera, S Pen',
                'price' => 279999,
                'sale_price' => 249999,
                'sku' => 'SAM-S24U-001',
                'stock' => 35,
                'category_id' => $electronics->id,
                'brand_id' => $samsung->id,
                'featured' => true,
                'best_seller' => false,
                'status' => 'published',
                'rating' => 4.7,
                'reviews_count' => 85
            ]
        );

        $product3 = Product::updateOrCreate(
            ['slug' => 'sony-wh-1000xm5'],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Industry-leading noise cancellation with exceptional sound quality. Features 30-hour battery life, quick charging, and premium comfort.',
                'short_description' => 'Best noise cancellation, 30hr battery',
                'price' => 65000,
                'sale_price' => 59000,
                'sku' => 'SON-WH1000XM5-001',
                'stock' => 20,
                'category_id' => $electronics->id,
                'brand_id' => $sony->id,
                'featured' => false,
                'best_seller' => true,
                'status' => 'published',
                'rating' => 4.9,
                'reviews_count' => 45
            ]
        );

        $product4 = Product::updateOrCreate(
            ['slug' => 'nike-air-max-270'],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'The Nike Air Max 270 features a large Air Max unit for maximum comfort and style. Perfect for casual wear and light running.',
                'short_description' => 'Large Air Max unit, Comfortable',
                'price' => 22000,
                'sale_price' => null,
                'sku' => 'NKE-AM270-001',
                'stock' => 60,
                'category_id' => $fashion->id,
                'brand_id' => $nike->id,
                'featured' => false,
                'best_seller' => false,
                'status' => 'published',
                'rating' => 4.5,
                'reviews_count' => 30
            ]
        );

        // ============================================
        // 4. CREATE PRODUCT IMAGES (if not exists)
        // ============================================
        if ($product1->images()->count() === 0) {
            ProductImage::create([
                'product_id' => $product1->id,
                $product->images()->create([
    'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop',
    'is_primary' => true,
]);
                'sort_order' => 0
            ]);
        }

        if ($product2->images()->count() === 0) {
            ProductImage::create([
                'product_id' => $product2->id,
              $product->images()->create([
    'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop',
    'is_primary' => true,
]);
                'sort_order' => 0
            ]);
        }

        if ($product3->images()->count() === 0) {
            ProductImage::create([
                'product_id' => $product3->id,
               $product->images()->create([
    'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop',
    'is_primary' => true,
]);
                'sort_order' => 0
            ]);
        }

        if ($product4->images()->count() === 0) {
            ProductImage::create([
                'product_id' => $product4->id,
                $product->images()->create([
    'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&h=400&fit=crop',
    'is_primary' => true,
]);
                'sort_order' => 0
            ]);
        }

        $this->command->info('✅ Sample data seeded successfully!');
        $this->command->info('Products: ' . Product::count());
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Brands: ' . Brand::count());
    }
}
