<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Customer\Cart;
use App\Models\Customer\CartItem as CartItemModel;
use App\Models\Products\Product;
use App\Http\Requests\Customer\CheckoutRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::with(['items.product.images', 'items.product.brand'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Customers/Orders/Index', [
            'orders' => $orders->items(),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ]
        ]);
    }

    /**
     * Show single order details
     */
    public function show($id)
    {
        $order = Order::with([
            'items.product.images',
            'items.product.brand',
            'shippingAddress',
            'billingAddress',
            'payment'
        ])->findOrFail($id);

        // Check if order belongs to user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Customers/Orders/Show', [
            'order' => $order,
            'taxRate' => 17
        ]);
    }

    /**
     * Place a new order
     */
    public function store(CheckoutRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();

        // Get user's cart
        $cart = Cart::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Check stock for all items
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', 'Not enough stock for: ' . $item->product->name);
            }
        }

        // Calculate totals
        $subtotal = $cart->total;
        $shippingCost = $subtotal >= 5000 ? 0 : 150;
        $discount = session()->get('coupon.discount', 0);
        $taxAmount = ($subtotal - $discount) * 0.17;
        $totalAmount = $subtotal + $shippingCost + $taxAmount - $discount;

        // Generate order number
        $orderNumber = 'PAK-' . date('Ymd') . '-' . Str::random(6);

        // Create order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax_amount' => $taxAmount,
            'discount' => $discount,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'shipping_address_id' => $validated['address_id'],
            'billing_address_id' => $validated['address_id'], // Use same for now
            'notes' => $validated['notes'] ?? null,
            'coupon_code' => session()->get('coupon.code'),
            'shipping_method' => $validated['shipping_method'] ?? 'standard',
            'placed_at' => now(),
        ]);

        // Create order items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->price * $item->quantity,
            ]);

            // Reduce product stock
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();
        }

        // Clear cart
        $cart->items()->delete();
        $cart->total = 0;
        $cart->save();

        // Clear session data
        session()->forget(['coupon', 'free_shipping']);

        // Create payment record (will be updated after payment)
        // Payment::create(['order_id' => $order->id, ...]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Cancel an order
     */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Check if order belongs to user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        // Update order status
        $order->status = 'cancelled';
        $order->cancelled_at = now();
        $order->save();

        // Restore stock
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->stock += $item->quantity;
            $product->save();
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order cancelled successfully.');
    }

    /**
     * Track an order
     */
    public function track($id)
    {
        $order = Order::with(['tracking'])->findOrFail($id);

        // Check if order belongs to user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Customers/Orders/Track', [
            'order' => $order
        ]);
    }
}
