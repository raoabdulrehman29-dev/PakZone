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
        // Share categories and cart count with all views
        Inertia::share([
            'categories' => function () {
                return Category::with('children')
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            },
            'cart_count' => function () {
                if (auth()->check()) {
                    return auth()->user()->cart?->items()->sum('quantity') ?? 0;
                }
                return 0;
            },
        ]);
    }
}
