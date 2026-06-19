<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Wishlist;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    /**
     * Show wishlist
     */
    public function index()
    {
        $wishlist = Wishlist::with(['product.images', 'product.brand'])
            ->where('user_id', auth()->id())
            ->get();

        return Inertia::render('Customers/Wishlist/Index', [
            'wishlist' => $wishlist
        ]);
    }

    /**
     * Toggle wishlist (add/remove)
     */
    public function toggle($productId)
    {
        $user = auth()->user();

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Removed from wishlist';
            $action = 'removed';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $message = 'Added to wishlist';
            $action = 'added';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $action
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Remove from wishlist
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return back()->with('success', 'Removed from wishlist');
    }

    /**
     * Move wishlist item to cart
     */
    public function moveToCart($id)
    {
        // Will implement after CartController is ready
        return back()->with('success', 'Item moved to cart');
    }
}
