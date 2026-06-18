<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Wishlist;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with(['product', 'product.images'])
            ->where('user_id', auth()->id())
            ->get();

        return Inertia::render('Customer/Wishlist/Index', [
            'wishlist' => $wishlist,
        ]);
    }

    public function toggle($productId)
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Removed from wishlist');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
        ]);

        return back()->with('success', 'Added to wishlist');
    }

    public function remove($id)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Removed from wishlist');
    }

    public function moveToCart($id)
    {
        // Will implement later
        return back()->with('success', 'Moved to cart');
    }
}
