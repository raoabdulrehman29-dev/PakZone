<?php

namespace Database\Seeders;

use App\Models\Products\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            // Electronics Brands
            ['name' => 'Apple', 'slug' => 'apple', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Samsung', 'slug' => 'samsung', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Sony', 'slug' => 'sony', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Dell', 'slug' => 'dell', 'is_featured' => false, 'is_active' => true],
            ['name' => 'HP', 'slug' => 'hp', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Lenovo', 'slug' => 'lenovo', 'is_featured' => false, 'is_active' => true],
            ['name' => 'OnePlus', 'slug' => 'oneplus', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi', 'is_featured' => false, 'is_active' => true],

            // Fashion Brands
            ['name' => 'Nike', 'slug' => 'nike', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Adidas', 'slug' => 'adidas', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Puma', 'slug' => 'puma', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Gucci', 'slug' => 'gucci', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Zara', 'slug' => 'zara', 'is_featured' => false, 'is_active' => true],
            ['name' => 'H&M', 'slug' => 'hm', 'is_featured' => false, 'is_active' => true],

            // Home Brands
            ['name' => 'IKEA', 'slug' => 'ikea', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Philips', 'slug' => 'philips', 'is_featured' => false, 'is_active' => true],
            ['name' => 'KitchenAid', 'slug' => 'kitchenaid', 'is_featured' => false, 'is_active' => true],

            // Books
            ['name' => 'Penguin', 'slug' => 'penguin', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Oxford', 'slug' => 'oxford', 'is_featured' => false, 'is_active' => true],

            // Sports
            ['name' => 'Decathlon', 'slug' => 'decathlon', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Wilson', 'slug' => 'wilson', 'is_featured' => false, 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        $this->command->info('✅ Brands seeded successfully!');
    }
}
