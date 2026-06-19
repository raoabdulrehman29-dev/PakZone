<?php

namespace App\Http\Middleware;

use App\Models\Customer\Cart;
use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'cart_count' => fn () => $this->cartCount($request),
            'categories' => fn () => $this->navbarCategories(),
        ];
    }

    private function cartCount(Request $request): int
    {
        if ($request->user()) {
            return (int) Cart::where('user_id', $request->user()->id)
                ->where('status', 'active')
                ->first()
                ?->items()
                ->sum('quantity');
        }

        return collect($request->session()->get('cart', []))->sum('quantity');
    }

    private function navbarCategories()
    {
        return Category::active()
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
                    'icon' => $category->icon,
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
    }
}
