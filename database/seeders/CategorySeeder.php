<?php

namespace Database\Seeders;

use App\Models\Products\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Main Categories
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronics and gadgets',
                'icon' => 'fa-laptop',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Trendy fashion for men and women',
                'icon' => 'fa-tshirt',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'description' => 'Everything for your home',
                'icon' => 'fa-home',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, music, and movies',
                'icon' => 'fa-book',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'icon' => 'fa-running',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            $parent = Category::create($category);

            // Sub-categories for Electronics
            if ($category['slug'] === 'electronics') {
                $subCategories = [
                    ['name' => 'Mobile Phones', 'slug' => 'mobile-phones', 'parent_id' => $parent->id],
                    ['name' => 'Laptops', 'slug' => 'laptops', 'parent_id' => $parent->id],
                    ['name' => 'Tablets', 'slug' => 'tablets', 'parent_id' => $parent->id],
                    ['name' => 'Headphones', 'slug' => 'headphones', 'parent_id' => $parent->id],
                    ['name' => 'Cameras', 'slug' => 'cameras', 'parent_id' => $parent->id],
                    ['name' => 'Smart Home', 'slug' => 'smart-home', 'parent_id' => $parent->id],
                ];
                foreach ($subCategories as $sub) {
                    Category::create($sub);
                }
            }

            // Sub-categories for Fashion
            if ($category['slug'] === 'fashion') {
                $subCategories = [
                    ['name' => "Men's Clothing", 'slug' => 'mens-clothing', 'parent_id' => $parent->id],
                    ['name' => "Women's Clothing", 'slug' => 'womens-clothing', 'parent_id' => $parent->id],
                    ['name' => 'Shoes', 'slug' => 'shoes', 'parent_id' => $parent->id],
                    ['name' => 'Accessories', 'slug' => 'accessories', 'parent_id' => $parent->id],
                ];
                foreach ($subCategories as $sub) {
                    Category::create($sub);
                }
            }
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}
