<?php

namespace App\Http\Controllers\Customer\Products;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->where('status', 'published');

        // Apply filters
        if ($request->filled('categories')) {
            $categories = collect(explode(',', $request->categories))
                ->filter()
                ->map(fn ($id) => (int) $id);

            $childIds = Category::whereIn('parent_id', $categories)->pluck('id');
            $query->whereIn('category_id', $categories->merge($childIds)->unique()->values());
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        if ($request->filled('ratings')) {
            $ratings = explode(',', $request->ratings);
            $query->whereIn('rating', $ratings);
        }

        if ($request->filled('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Sorting
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

        $products = $query->paginate(12)->through(fn (Product $product) => $this->formatProduct($product));
        $categories = Category::active()
            ->parents()
            ->with(['children' => fn ($query) => $query->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get()
            ->map(function (Category $category) {
                $childIds = $category->children->pluck('id');
                $categoryIds = $childIds->push($category->id);

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'products_count' => Product::published()->whereIn('category_id', $categoryIds)->count(),
                    'children' => $category->children->map(fn (Category $child) => [
                        'id' => $child->id,
                        'name' => $child->name,
                        'slug' => $child->slug,
                        'products_count' => Product::published()->where('category_id', $child->id)->count(),
                    ])->values(),
                ];
            })
            ->values();

        return Inertia::render('Products/Index', [
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
            'categories' => $categories,
            'filters' => $request->all(),
        ]);
    }

public function show($slug)
{
    try {
        $product = Product::with([
            'category',
            'brand',
            'images',
            'variants',
            'reviews' => function ($query) {
                $query->where('status', 'approved')->latest()->limit(10);
            }
        ])->where('slug', $slug)
          ->where('status', 'published')
          ->firstOrFail();

        // Increment views
        $product->increment('views');

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        return Inertia::render('Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'user' => auth()->user(),
        ]);
    } catch (\Exception $e) {
        return redirect()->route('products.index')
            ->with('error', 'Product not found.');
    }
}

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = null;

        if ($query) {
            $products = Product::where(function ($builder) use ($query) {
                    $builder->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%")
                        ->orWhere('sku', 'LIKE', "%{$query}%");
                })
                ->where('status', 'published')
                ->with(['category', 'brand', 'images'])
                ->paginate(12)
                ->through(fn (Product $product) => $this->formatProduct($product));
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

    private function formatProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'final_price' => $product->final_price,
            'sale_price' => $product->sale_price,
            'discount_percentage' => $product->discount_percentage,
            'image' => $product->images->first()?->image,
            'brand' => $product->brand?->name,
            'rating' => $product->rating,
            'reviews_count' => $product->reviews_count,
            'stock' => $product->stock,
            'sku' => $product->sku,
            'best_seller' => $product->best_seller,
            'category' => $product->category,
        ];
    }
}
