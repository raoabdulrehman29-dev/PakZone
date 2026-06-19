<?php

namespace Database\Seeders;

use App\Models\Products\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Electronics (parent)
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronics and gadgets',
                'icon' => 'fa-laptop',
                'is_active' => true,
                'sort_order' => 1,
            ],
            // Fashion (parent)
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Trendy fashion for men and women',
                'icon' => 'fa-tshirt',
                'is_active' => true,
                'sort_order' => 2,
            ],
            // Home & Kitchen (parent)
            [
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'description' => 'Everything for your home',
                'icon' => 'fa-home',
                'is_active' => true,
                'sort_order' => 3,
            ],
            // Books & Media (parent)
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, music, and movies',
                'icon' => 'fa-book',
                'is_active' => true,
                'sort_order' => 4,
            ],
            // Sports & Outdoors (parent)
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'icon' => 'fa-running',
                'is_active' => true,
                'sort_order' => 5,
            ],
            // Beauty & Personal Care (parent)
            [
                'name' => 'Beauty & Personal Care',
                'slug' => 'beauty-personal-care',
                'description' => 'Beauty products and personal care',
                'icon' => 'fa-spa',
                'is_active' => true,
                'sort_order' => 6,
            ],
            // Automotive (parent)
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Car parts and accessories',
                'icon' => 'fa-car',
                'is_active' => true,
                'sort_order' => 7,
            ],
            // Toys & Games (parent)
            [
                'name' => 'Toys & Games',
                'slug' => 'toys-games',
                'description' => 'Toys, board games, and collectibles',
                'icon' => 'fa-gamepad',
                'is_active' => true,
                'sort_order' => 8,
            ],
            // Health & Wellness (parent)
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Health supplies and wellness products',
                'icon' => 'fa-heartbeat',
                'is_active' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create($categoryData);

            // Add sub-categories based on parent
            $subCategories = $this->getSubCategories($categoryData['slug']);
            foreach ($subCategories as $sub) {
                $sub['parent_id'] = $parent->id;
                Category::create($sub);
            }
        }

        $this->command->info('✅ Categories seeded successfully!');
    }

    private function getSubCategories($parentSlug)
    {
        $subs = [
            'electronics' => [
                ['name' => 'Mobile Phones', 'slug' => 'mobile-phones', 'is_active' => true],
                ['name' => 'Smartphones', 'slug' => 'smartphones', 'is_active' => true],
                ['name' => 'Feature Phones', 'slug' => 'feature-phones', 'is_active' => true],
                ['name' => 'Laptops', 'slug' => 'laptops', 'is_active' => true],
                ['name' => 'Gaming Laptops', 'slug' => 'gaming-laptops', 'is_active' => true],
                ['name' => 'Ultrabooks', 'slug' => 'ultrabooks', 'is_active' => true],
                ['name' => 'Tablets', 'slug' => 'tablets', 'is_active' => true],
                ['name' => 'Headphones', 'slug' => 'headphones', 'is_active' => true],
                ['name' => 'Wireless Earbuds', 'slug' => 'wireless-earbuds', 'is_active' => true],
                ['name' => 'Over-Ear Headphones', 'slug' => 'over-ear-headphones', 'is_active' => true],
                ['name' => 'Cameras', 'slug' => 'cameras', 'is_active' => true],
                ['name' => 'DSLR Cameras', 'slug' => 'dslr-cameras', 'is_active' => true],
                ['name' => 'Mirrorless Cameras', 'slug' => 'mirrorless-cameras', 'is_active' => true],
                ['name' => 'Smart Home', 'slug' => 'smart-home', 'is_active' => true],
                ['name' => 'Smart Speakers', 'slug' => 'smart-speakers', 'is_active' => true],
                ['name' => 'Smart Lighting', 'slug' => 'smart-lighting', 'is_active' => true],
            ],
            'fashion' => [
                ['name' => "Men's Clothing", 'slug' => 'mens-clothing', 'is_active' => true],
                ['name' => "Men's Shirts", 'slug' => 'mens-shirts', 'is_active' => true],
                ['name' => "Men's Trousers", 'slug' => 'mens-trousers', 'is_active' => true],
                ['name' => "Men's Jackets", 'slug' => 'mens-jackets', 'is_active' => true],
                ['name' => "Women's Clothing", 'slug' => 'womens-clothing', 'is_active' => true],
                ['name' => "Women's Dresses", 'slug' => 'womens-dresses', 'is_active' => true],
                ['name' => "Women's Tops", 'slug' => 'womens-tops', 'is_active' => true],
                ['name' => "Women's Skirts", 'slug' => 'womens-skirts', 'is_active' => true],
                ['name' => 'Shoes', 'slug' => 'shoes', 'is_active' => true],
                ['name' => 'Running Shoes', 'slug' => 'running-shoes', 'is_active' => true],
                ['name' => 'Casual Shoes', 'slug' => 'casual-shoes', 'is_active' => true],
                ['name' => 'Formal Shoes', 'slug' => 'formal-shoes', 'is_active' => true],
                ['name' => 'Accessories', 'slug' => 'accessories', 'is_active' => true],
                ['name' => 'Watches', 'slug' => 'watches', 'is_active' => true],
                ['name' => 'Bags', 'slug' => 'bags', 'is_active' => true],
            ],
            'home-kitchen' => [
                ['name' => 'Furniture', 'slug' => 'furniture', 'is_active' => true],
                ['name' => 'Sofas', 'slug' => 'sofas', 'is_active' => true],
                ['name' => 'Tables', 'slug' => 'tables', 'is_active' => true],
                ['name' => 'Chairs', 'slug' => 'chairs', 'is_active' => true],
                ['name' => 'Kitchen Appliances', 'slug' => 'kitchen-appliances', 'is_active' => true],
                ['name' => 'Refrigerators', 'slug' => 'refrigerators', 'is_active' => true],
                ['name' => 'Microwaves', 'slug' => 'microwaves', 'is_active' => true],
                ['name' => 'Blenders', 'slug' => 'blenders', 'is_active' => true],
                ['name' => 'Cookware', 'slug' => 'cookware', 'is_active' => true],
                ['name' => 'Pots & Pans', 'slug' => 'pots-pans', 'is_active' => true],
                ['name' => 'Bakeware', 'slug' => 'bakeware', 'is_active' => true],
            ],
            'books-media' => [
                ['name' => 'Fiction Books', 'slug' => 'fiction-books', 'is_active' => true],
                ['name' => 'Non-Fiction Books', 'slug' => 'non-fiction-books', 'is_active' => true],
                ['name' => 'Educational Books', 'slug' => 'educational-books', 'is_active' => true],
                ['name' => 'Music CDs', 'slug' => 'music-cds', 'is_active' => true],
                ['name' => 'Vinyl Records', 'slug' => 'vinyl-records', 'is_active' => true],
                ['name' => 'Movies & TV', 'slug' => 'movies-tv', 'is_active' => true],
            ],
            'sports-outdoors' => [
                ['name' => 'Fitness Equipment', 'slug' => 'fitness-equipment', 'is_active' => true],
                ['name' => 'Treadmills', 'slug' => 'treadmills', 'is_active' => true],
                ['name' => 'Exercise Bikes', 'slug' => 'exercise-bikes', 'is_active' => true],
                ['name' => 'Sports Gear', 'slug' => 'sports-gear', 'is_active' => true],
                ['name' => 'Football', 'slug' => 'football', 'is_active' => true],
                ['name' => 'Cricket', 'slug' => 'cricket', 'is_active' => true],
                ['name' => 'Outdoor Recreation', 'slug' => 'outdoor-recreation', 'is_active' => true],
                ['name' => 'Camping', 'slug' => 'camping', 'is_active' => true],
                ['name' => 'Hiking', 'slug' => 'hiking', 'is_active' => true],
            ],
            'beauty-personal-care' => [
                ['name' => 'Makeup', 'slug' => 'makeup', 'is_active' => true],
                ['name' => 'Skincare', 'slug' => 'skincare', 'is_active' => true],
                ['name' => 'Haircare', 'slug' => 'haircare', 'is_active' => true],
                ['name' => 'Fragrances', 'slug' => 'fragrances', 'is_active' => true],
                ['name' => 'Personal Care', 'slug' => 'personal-care', 'is_active' => true],
            ],
            'automotive' => [
                ['name' => 'Car Parts', 'slug' => 'car-parts', 'is_active' => true],
                ['name' => 'Car Accessories', 'slug' => 'car-accessories', 'is_active' => true],
                ['name' => 'Motorcycle Parts', 'slug' => 'motorcycle-parts', 'is_active' => true],
                ['name' => 'Tools', 'slug' => 'tools', 'is_active' => true],
            ],
            'toys-games' => [
                ['name' => 'Board Games', 'slug' => 'board-games', 'is_active' => true],
                ['name' => 'Outdoor Toys', 'slug' => 'outdoor-toys', 'is_active' => true],
                ['name' => 'Collectibles', 'slug' => 'collectibles', 'is_active' => true],
                ['name' => 'Educational Toys', 'slug' => 'educational-toys', 'is_active' => true],
            ],
            'health-wellness' => [
                ['name' => 'Vitamins', 'slug' => 'vitamins', 'is_active' => true],
                ['name' => 'Supplements', 'slug' => 'supplements', 'is_active' => true],
                ['name' => 'Medical Supplies', 'slug' => 'medical-supplies', 'is_active' => true],
            ],
        ];

        return $subs[$parentSlug] ?? [];
    }
}
