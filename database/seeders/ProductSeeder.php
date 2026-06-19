<?php

namespace Database\Seeders;

use App\Models\Products\Product;
use App\Models\Products\Category;
use App\Models\Products\Brand;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categories = Category::where('is_active', true)->pluck('id')->toArray();
        $brands = Brand::where('is_active', true)->pluck('id')->toArray();

        // Create 200 products
        for ($i = 0; $i < 200; $i++) {
            Product::create([
                'name' => $faker->words(rand(2, 4), true),
                'slug' => $faker->unique()->slug(),
                'sku' => 'SKU-' . strtoupper($faker->unique()->bothify('???-#####')),
                'description' => $faker->paragraphs(rand(2, 4), true),
                'short_description' => $faker->sentence(rand(8, 15)),
                'price' => $faker->randomFloat(2, 100, 10000),
                'sale_price' => $faker->optional(0.4)->randomFloat(2, 50, 8000),
                'stock' => $faker->numberBetween(0, 100),
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->optional(0.7)->randomElement($brands),
                'featured' => $faker->boolean(15),
                'best_seller' => $faker->boolean(10),
                'status' => 'published',
                'rating' => $faker->randomFloat(2, 3, 5),
                'reviews_count' => $faker->numberBetween(0, 100),
                'views' => $faker->numberBetween(0, 1000),
                'weight' => $faker->optional(0.5)->randomFloat(2, 0.5, 10),
                'dimensions' => $faker->optional(0.3)->randomElement([
                    '10x5x3', '15x8x4', '20x10x5', '12x6x4', '8x4x2'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ 200 products created successfully!');
        $this->command->info('Total products: ' . Product::count());
    }
}
