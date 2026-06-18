<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // Get category with sub-categories
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();

        // Get products in this category (including sub-categories)
        $categoryIds = $category->children->pluck('id')->push($category->id)->toArray();

        $products = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'published')
            ->with(['category', 'brand', 'images'])
            ->paginate(12);

        return Inertia::render('Categories/Show', [
            'category' => $category,
            'subCategories' => $category->children,
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }
}
