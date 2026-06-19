<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\Customer\Address;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Products\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Get users with addresses
        $users = User::role('customer')
            ->whereHas('addresses')
            ->get();

        $products = Product::where('stock', '>', 0)->get();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('⚠️ No users with addresses or products found. Skipping orders.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();

            // Get user's addresses
            $addresses = $user->addresses;
            $shippingAddress = $addresses->random();
            $billingAddress = $addresses->where('type', 'billing')->first() ?? $shippingAddress;

            $orderItems = [];

            // Generate random order items
            $numItems = rand(1, 5);
            $selectedProducts = $products->random(min($numItems, $products->count()));
            $subtotal = 0;

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->sale_price ?? $product->price;
                $total = $price * $quantity;
                $subtotal += $total;
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ];
            }

            // Generate shipping cost
            $shippingCost = $subtotal > 5000 ? 0 : 150;

            // Generate tax
            $taxAmount = ($subtotal - 0) * 0.17;

            // Generate discount
            $discount = rand(0, 10) > 7 ? rand(100, 500) : 0;

            // Calculate total
            $totalAmount = $subtotal + $shippingCost + $taxAmount - $discount;

            // Create order with addresses
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax_amount' => $taxAmount,
                'discount' => $discount,
                'total_amount' => $totalAmount,
                'status' => $statuses[array_rand($statuses)],
                'payment_status' => rand(0, 1) ? 'pending' : 'paid',
                'shipping_address_id' => $shippingAddress->id,
                'billing_address_id' => $billingAddress->id,
                'notes' => rand(0, 1) ? 'Please handle with care.' : null,
                'coupon_code' => null,
                'tracking_number' => rand(0, 1) ? 'TRK' . rand(10000, 99999) : null,
                'shipping_method' => rand(0, 1) ? 'Standard' : 'Express',
                'placed_at' => now()->subDays(rand(0, 30)),
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }
        }

        $this->command->info('✅ Orders seeded successfully!');
    }
}
