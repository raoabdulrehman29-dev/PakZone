<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Cart;
use App\Models\Customer\CartItem;
use App\Models\Products\Product;
use App\Models\Coupons\Coupon;
use App\Http\Requests\Customer\AddToCartRequest;
use App\Http\Requests\Customer\UpdateCartRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $user = auth()->user();
        $cartItems = collect([]);
        $subtotal = 0;
        $shippingCost = 0;
        $discount = 0;
        $total = 0;
        $savedItems = collect([]);

        if ($user) {
            // Get user's cart with items
            $cart = Cart::with(['items.product.images', 'items.product.brand'])
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if ($cart) {
                $cartItems = $cart->items()
                    ->with(['product.images', 'product.brand', 'variant'])
                    ->get()
                    ->map(fn (CartItem $item) => $this->formatCartItem($item));
                $subtotal = $cart->calculateTotal();

                // Get saved items (status = 'saved')
                $savedItems = CartItem::with(['product.images', 'product.brand'])
                    ->whereHas('cart', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->get()
                    ->map(fn (CartItem $item) => $this->formatCartItem($item));
            }
        } else {
            // Guest cart from session
            $sessionCart = session()->get('cart', []);
            $cartItems = collect($sessionCart)->values();
            $subtotal = $this->calculateSessionTotal($sessionCart);
        }

        // Calculate shipping (free above 5000)
        $shippingCost = $subtotal >= 5000 ? 0 : 150;

        // Get applied coupon from session
        $couponData = session()->get('coupon');
        if ($couponData) {
            $discount = $couponData['discount'] ?? 0;
        }

        $total = $subtotal + $shippingCost - $discount;

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'savedItems' => $savedItems,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'discount' => $discount,
            'tax' => 0,
            'total' => $total,
            'taxRate' => 17,
            'freeShippingThreshold' => 5000,
        ]);
    }

    /**
     * Add item to cart
     */
    public function add(AddToCartRequest $request)
    {
        $validated = $request->validated();

        // Get product with stock check
        $product = Product::with('images')->findOrFail($validated['product_id']);

        // Check stock
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available! Only ' . $product->stock . ' left.');
        }

        // Check if user is logged in
        if (auth()->check()) {
            $user = auth()->user();

            // Get or create active cart
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'status' => 'active'],
                ['total' => 0]
            );

            // Check if product already in cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->where('variant_id', $validated['variant_id'] ?? null)
                ->first();

            if ($cartItem) {
                // Update quantity
                $cartItem->quantity += $validated['quantity'];
                $cartItem->save();
            } else {
                // Add new item
                $cartItem = $cart->items()->create([
                    'product_id' => $product->id,
                    'variant_id' => $validated['variant_id'] ?? null,
                    'quantity' => $validated['quantity'],
                    'price' => $product->final_price ?? $product->price,

                ]);
            }

            // Recalculate cart total
            $cart->calculateTotal();

        } else {
            // Guest user - store in session
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                // Update quantity
                $cart[$product->id]['quantity'] += $validated['quantity'];
            } else {
                // Add new item
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->final_price ?? $product->price,
                    'original_price' => $product->price,
                    'quantity' => $validated['quantity'],
                    'image' => $product->images->first()->image ?? null,
                    'stock' => $product->stock,
                    'sku' => $product->sku,
                    'max_stock' => $product->stock
                ];
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')
            ->with('success', $product->name . ' added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(UpdateCartRequest $request, $id)
    {
        $validated = $request->validated();

        if (!auth()->check()) {
            $cart = session()->get('cart', []);

            if (!isset($cart[$id])) {
                abort(404);
            }

            if ($validated['quantity'] > $cart[$id]['max_stock']) {
                return back()->with('error', 'Not enough stock available! Only ' . $cart[$id]['max_stock'] . ' left.');
            }

            $cart[$id]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);

            return redirect()->route('cart.index')
                ->with('success', 'Cart updated successfully!');
        }

        // Find cart item
        $cartItem = CartItem::with('product')->findOrFail($id);

        // Check ownership (if user is logged in)
        if (auth()->check()) {
            $cart = $cartItem->cart;
            if ($cart->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Check stock
        $product = $cartItem->product;
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available! Only ' . $product->stock . ' left.');
        }

        // Update quantity
        $cartItem->quantity = $validated['quantity'];
        $cartItem->save();

        // Recalculate cart total
        $cartItem->cart->calculateTotal();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_item' => $cartItem,
                'cart_total' => $cartItem->cart->total,
                'subtotal' => $cartItem->cart->total
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        if (!auth()->check()) {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->route('cart.index')
                ->with('success', 'Item removed from cart.');
        }

        $cartItem = CartItem::findOrFail($id);

        // Check ownership
        if (auth()->check()) {
            $cart = $cartItem->cart;
            if ($cart->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $cartItem->delete();

        // Recalculate cart total
        if (isset($cart)) {
            $cart->calculateTotal();
        }

        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }

    /**
     * Save item for later
     */
    public function saveForLater($id)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Please login to save items for later.');
        }

        $cartItem = CartItem::findOrFail($id);

        // Check ownership
        if (auth()->check()) {
            $cart = $cartItem->cart;
            if ($cart->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Change status to 'saved'
        $cartItem->save();

        // Recalculate cart total
        if (isset($cart)) {
            $cart->calculateTotal();
        }

        return redirect()->route('cart.index')
            ->with('success', 'Item saved for later.');
    }

    /**
     * Move saved item back to cart
     */
    public function moveToCart($id)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Please login to move saved items.');
        }

        $cartItem = CartItem::findOrFail($id);

        // Check ownership
        if (auth()->check()) {
            $cart = $cartItem->cart;
            if ($cart->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Check stock
        $product = $cartItem->product;
        if ($product->stock < $cartItem->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        // Change status back to 'active'
        $cartItem->status = 'active';
        $cartItem->save();

        // Recalculate cart total
        if (isset($cart)) {
            $cart->calculateTotal();
        }

        return redirect()->route('cart.index')
            ->with('success', 'Item moved to cart.');
    }

    /**
     * Apply coupon to cart
     */
    public function applyCoupon(Request $request)
    {
        $code = $request->input('code');

        if (empty($code)) {
            return back()->with('error', 'Please enter a coupon code.');
        }

        // Find coupon
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return back()->with('error', 'This coupon has reached its usage limit.');
        }

        // Get user's cart
        $user = auth()->user();
        if (!$user) {
            return back()->with('error', 'Please login to apply coupon.');
        }

        $cart = Cart::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->total;

        // Check minimum order
        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return back()->with('error', 'Minimum order amount is Rs. ' . number_format($coupon->min_order_amount));
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value) / 100;
            if ($coupon->max_discount && $discount > $coupon->max_discount) {
                $discount = $coupon->max_discount;
            }
        } elseif ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } elseif ($coupon->type === 'free_shipping') {
            // Free shipping will be applied separately
            $discount = 0;
            session()->put('free_shipping', true);
        }

        // Store coupon in session
        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'coupon_id' => $coupon->id
        ]);

        // Update cart total
        $cart->total = $subtotal - $discount;
        $cart->save();

        return redirect()->route('cart.index')
            ->with('success', "Coupon '{$coupon->code}' applied! You saved Rs. " . number_format($discount));
    }

    /**
     * Clear the entire cart
     */
    public function clear()
    {
        $user = auth()->user();

        if ($user) {
            $cart = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if ($cart) {
                $cart->items()->delete();
                $cart->total = 0;
                $cart->save();
            }
        } else {
            session()->forget('cart');
        }

        session()->forget('coupon');

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully.');
    }

    /**
     * Calculate session cart total for guests
     */
    private function calculateSessionTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    private function formatCartItem(CartItem $item): array
    {
        $product = $item->product;

        return [
            'id' => $item->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $item->price,
            'original_price' => $product->price,
            'quantity' => $item->quantity,
            'image' => $product->images->first()?->image,
            'stock' => $product->stock,
            'sku' => $product->sku,
            'max_stock' => $product->stock,
            'variant' => $item->variant?->value,
        ];
    }
}
