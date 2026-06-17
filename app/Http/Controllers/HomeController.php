<?php

namespace App\Http\Controllers;

use App\Models\Products\Category;
use App\Models\Products\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Get categories with children
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'icon' => $category->icon,
                    'children' => $category->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'name' => $child->name,
                            'slug' => $child->slug,
                        ];
                    }),
                ];
            });

        // Get featured products
        $products = Product::with(['images', 'brand', 'category'])
            ->where('status', 'published')
            ->where('featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'original_price' => $product->sale_price,
                    'discount_percentage' => $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : null,
                    'image' => $product->images->first()?->image ?? null,
                    'brand' => $product->brand?->name,
                    'rating' => $product->rating,
                    'reviews_count' => $product->reviews_count,
                    'sold_count' => 0, // You can calculate this from orders
                ];
            });

        return Inertia::render('Home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
