<?php

namespace App\Http\Controllers;

use App\Models\Products\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Inertia::share([
            'categories' => function () {
                try {
                    return Category::with('children')
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
                } catch (\Exception $e) {
                    return collect([]);
                }
            },
            'cart_count' => function () {
                if (!auth()->check()) {
                    return 0;
                }

                try {
                    $user = auth()->user();
                    $cart = $user->cart;

                    if (!$cart) {
                        return 0;
                    }

                    return $cart->items()->sum('quantity') ?? 0;
                } catch (\Exception $e) {
                    return 0;
                }
            },
        ]);
    }
}
