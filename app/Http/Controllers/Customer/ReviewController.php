<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Review;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display user's reviews.
     */
    public function index()
    {
        $reviews = Review::with(['product', 'product.images'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Review::where('user_id', auth()->id())->count(),
            'approved' => Review::where('user_id', auth()->id())->where('status', 'approved')->count(),
            'pending' => Review::where('user_id', auth()->id())->where('status', 'pending')->count(),
            'average_rating' => Review::where('user_id', auth()->id())->avg('rating') ?? 0,
        ];

        return Inertia::render('Customers/Reviews/Index', [
            'reviews' => $reviews->items(),
            'stats' => $stats,
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
            ],
        ]);
    }

    /**
     * Show create review form.
     */
    public function create(Request $request)
    {
        $productId = $request->input('product_id');

        if ($productId) {
            $product = Product::findOrFail($productId);
            return Inertia::render('Customers/Reviews/Create', [
                'product' => $product,
                'order_number' => null,
            ]);
        }

        return Inertia::render('Customers/Reviews/Create', [
            'product' => null,
            'order_number' => null,
        ]);
    }

    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $validated['user_id'] = auth()->id();
        $validated['is_verified'] = true;
        $validated['status'] = 'pending';

        Review::create($validated);

        // Update product rating
        $product = Product::find($validated['product_id']);
        if ($product) {
            $product->updateRating();
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Review submitted successfully!');
    }

    /**
     * Update a review.
     */
    public function update(Request $request, $id)
    {
        $review = Review::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string',
        ]);

        $review->update($validated);

        return redirect()->route('reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        $review = Review::where('user_id', auth()->id())->findOrFail($id);

        $review->delete();

        // Update product rating
        $product = Product::find($review->product_id);
        if ($product) {
            $product->updateRating();
        }

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully!');
    }
}
