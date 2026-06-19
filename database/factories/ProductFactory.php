<?php

namespace Database\Factories;

use App\Models\Products\Product;
use App\Models\Products\Category;
use App\Models\Products\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $categories = Category::where('is_active', true)->pluck('id')->toArray();
        $brands = Brand::where('is_active', true)->pluck('id')->toArray();

        return [
            'name' => $this->faker->words(rand(2, 4), true),
            'slug' => $this->faker->unique()->slug(),
            'sku' => 'SKU-' . strtoupper($this->faker->unique()->bothify('???-#####')),
            'description' => $this->faker->paragraphs(rand(2, 4), true),
            'short_description' => $this->faker->sentence(rand(8, 15)),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'sale_price' => $this->faker->optional(0.4)->randomFloat(2, 50, 8000),
            'stock' => $this->faker->numberBetween(0, 100),
            'category_id' => $this->faker->randomElement($categories),
            'brand_id' => $this->faker->optional(0.7)->randomElement($brands),
            'featured' => $this->faker->boolean(15),
            'best_seller' => $this->faker->boolean(10),
            'status' => 'published',
            'rating' => $this->faker->randomFloat(2, 3, 5),
            'reviews_count' => $this->faker->numberBetween(0, 100),
            'views' => $this->faker->numberBetween(0, 1000),
            'weight' => $this->faker->optional(0.5)->randomFloat(2, 0.5, 10),
            'dimensions' => $this->faker->optional(0.3)->randomElement([
                '10x5x3', '15x8x4', '20x10x5', '12x6x4', '8x4x2'
            ]),
        ];
    }
}
