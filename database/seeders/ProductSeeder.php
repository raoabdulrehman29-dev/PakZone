<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Products\Product;
use App\Models\Products\Category;
use  App\Models\Products\Brand;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(50)->published()->inStock()->create();
        Product::factory()->count(20)->featured()->create();
        Product::factory()->count(5)
        ->state(function( array $attributes ) {
             return [
                'best_seller' => true,
                'status' => 'published',
                'stock' => $this->faker->numberBetween(1,100),
             ];
        })->create();
        $this->command->info('✅ Products seeded successfully!');
    }

}
