// database/migrations/2026_06_16_000012_create_orders_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0.00);
            $table->decimal('tax_amount', 15, 2)->default(0.00);
            $table->decimal('discount', 15, 2)->default(0.00);
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->foreignId('shipping_address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('billing_address_id')->constrained('addresses')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('shipping_method')->nullable();
            $table->date('estimated_delivery')->nullable();
            $table->timestamp('placed_at');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('order_number');
            $table->index('status');
            $table->index('payment_status');
            $table->index('placed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
