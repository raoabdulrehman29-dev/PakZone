<?php

namespace App\Http\Controllers\Customer\Products;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerProductController extends Controller  // ← Changed from ProductController
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['category', 'brand', 'images'])
            ->where('status', 'published');

        if ($request->filled('categories')) {
            $categories = explode(',', $request->categories);
            $query->whereIn('category_id', $categories);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('ratings')) {
            $ratings = explode(',', $request->ratings);
            $query->whereIn('rating', $ratings);
        }

        if ($request->filled('in_stock')) {
            $query->where('stock', '>', 0);
        }

        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();

        return Inertia::render('Products/Index', [
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
            'categories' => $categories,
        ]);
    }

    public function show($slug)
    {
        $product = Product::with([
            'category',
            'brand',
            'images',
            'variants',
            'reviews' => function ($query) {
                $query->where('status', 'approved')->latest()->limit(10);
            }
        ])->where('slug', $slug)->firstOrFail();

        $product->increment('views');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        return Inertia::render('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = [];

        if ($query) {
            $products = Product::where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('sku', 'LIKE', "%{$query}%")
                ->where('status', 'published')
                ->with(['category', 'brand', 'images'])
                ->paginate(12);
        }

        return Inertia::render('Search', [
            'products' => $products->items() ?? [],
            'query' => $query,
            'pagination' => $products ? [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ] : null,
        ]);
    }
}
