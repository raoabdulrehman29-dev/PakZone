<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Products\Product;
use App\Models\Products\Category;
use App\Models\Products\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3,true),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->paragraph(3,true),
            'short_description' =>$this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2,10,10000),
            "sale_price" => $this->faker->optional(0,3)->randomFloat(2,100,10000),
            'sku' => $this->faker->unique(),ean13(),
            'stock' => $this->faker->numberBetween(1,100),
            'low_stock_threshold'=>$this->faker->numberBetween(1,50),
            'category_id' => Category::inRandomOrder()->first()?->id,
            'brand_id' => Brand::inRandomOrder()->first()?->id,
            'featured' =>$this->faker->boolean(20),
            'best_seller'=> $this->faker->boolean(20),
            'status' => $this->faker->randomElement(['drafs','published','achived']),
            'views' => $this->faker->numberBetween(1,100),
            'rating' => $this->faker->randomFloat(2,0,5),
            'reviews_count' => $this->faker->numberBetween(0,50),
            'weight' => $this->faker->randomFloat(2,0.5,10),
            'diminsions' => $this->faker->optional()->randomElement(
                [
                    '10x5x3',
                    '15x8x4',
                    '20,10,5',
                    null,
                ]
            ),
            'created_at' => now(),
            'updated_at' => now(),




        ];
    }
    public function published()
    {
        return $this->state(function(array $attributes)
        {
            return [
                'status' => 'published'
            ];
        });
    }
     public function inStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => $this->faker->numberBetween(1, 100),
            ];
        });
    }
   public function featured(){
    return $this->state(function(array $attributes)
    {
        return [
            'featured' => true,
            'status' => 'published',

        ];
    });
   }


}
