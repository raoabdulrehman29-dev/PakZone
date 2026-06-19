<?php

use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/search-suggestions', function (Request $request) {
    $query = $request->get('q');

    if (strlen($query) < 2) {
        return response()->json([]);
    }

    $products = Product::where('name', 'LIKE', "%{$query}%")
        ->where('status', 'published')
        ->limit(10)
        ->get(['id', 'name', 'slug', 'price']);

    return response()->json($products);
});
