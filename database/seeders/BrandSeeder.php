<?php

namespace Database\Seeders;

use App\Models\Products\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Apple', 'slug' => 'apple', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Samsung', 'slug' => 'samsung', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Nike', 'slug' => 'nike', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Adidas', 'slug' => 'adidas', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Sony', 'slug' => 'sony', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Dell', 'slug' => 'dell', 'is_featured' => false, 'is_active' => true],
            ['name' => 'HP', 'slug' => 'hp', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Lenovo', 'slug' => 'lenovo', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Gucci', 'slug' => 'gucci', 'is_featured' => false, 'is_active' => true],
            ['name' => 'Puma', 'slug' => 'puma', 'is_featured' => false, 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        $this->command->info('✅ Brands seeded successfully!');
    }
}
