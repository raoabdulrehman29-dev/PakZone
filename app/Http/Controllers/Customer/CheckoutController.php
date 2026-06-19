<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Address;
use App\Models\Customer\Cart;
use App\Models\Orders\Order;
use App\Http\Requests\Customer\CheckoutRequest;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $user = auth()->user();

        // Get user's cart
        $cart = Cart::with(['items.product.images'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Get user's addresses
        $addresses = Address::where('user_id', $user->id)->get();

        // Calculate totals
        $subtotal = $cart->total;
        $shippingCost = $subtotal >= 5000 ? 0 : 150;
        $discount = session()->get('coupon.discount', 0);
        $taxAmount = ($subtotal - $discount) * 0.17;
        $totalAmount = $subtotal + $shippingCost + $taxAmount - $discount;

        return Inertia::render('Cart/Checkout', [
            'cartItems' => $cart->items,
            'addresses' => $addresses,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'discount' => $discount,
            'tax' => $taxAmount,
            'total' => $totalAmount,
            'taxRate' => 17,
            'user' => $user,
        ]);
    }
}
