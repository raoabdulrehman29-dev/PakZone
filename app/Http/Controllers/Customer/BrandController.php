<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Products\Brand;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function show($slug)
    {
        // Get brand details
        $brand = Brand::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get products belonging to this brand
        $products = Product::where('brand_id', $brand->id)
            ->where('status', 'published')
            ->with(['category', 'brand', 'images'])
            ->paginate(12);

        return Inertia::render('Brands/Show', [
            'brand' => $brand,
            'products' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }
}
