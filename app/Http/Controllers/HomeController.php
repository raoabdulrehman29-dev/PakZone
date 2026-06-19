<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Models\Products\Category;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        // Get categories with product count
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($category) {
                $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();
                $productCount = Product::whereIn('category_id', $categoryIds)
                    ->where('status', 'published')
                    ->count();

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'icon' => $category->icon,
                    'products_count' => $productCount,
                    'children' => $category->children->map(function ($child) {
                        $childCount = Product::where('category_id', $child->id)
                            ->where('status', 'published')
                            ->count();
                        return [
                            'id' => $child->id,
                            'name' => $child->name,
                            'slug' => $child->slug,
                            'products_count' => $childCount,
                        ];
                    }),
                ];
            });

        // Get featured products (limit 8, not 3)
        $products = Product::with(['images', 'brand', 'category'])
            ->where('status', 'published')
            ->where('featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'final_price' => $product->final_price,
                    'sale_price' => $product->sale_price,
                    'discount_percentage' => $product->discount_percentage,
                    'image' => $product->images->first()?->image ?? null,
                    'brand' => $product->brand?->name,
                    'rating' => $product->rating,
                    'reviews_count' => $product->reviews_count,
                    'stock' => $product->stock,
                    'best_seller' => $product->best_seller,
                ];
            });

        // If no featured products, get regular published products
        if ($products->isEmpty()) {
            $products = Product::with(['images', 'brand', 'category'])
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'final_price' => $product->final_price,
                        'sale_price' => $product->sale_price,
                        'discount_percentage' => $product->discount_percentage,
                        'image' => $product->images->first()?->image ?? null,
                        'brand' => $product->brand?->name,
                        'rating' => $product->rating,
                        'reviews_count' => $product->reviews_count,
                        'stock' => $product->stock,
                        'best_seller' => $product->best_seller,
                    ];
                });
        }

        return Inertia::render('Home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
