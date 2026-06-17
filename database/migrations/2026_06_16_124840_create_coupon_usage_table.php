// database/migrations/2026_06_16_000020_create_coupon_usage_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupon_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('discount_amount', 15, 2);
            $table->timestamp('used_at');
            $table->timestamps();

            $table->index('coupon_id');
            $table->index('order_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_usage');
    }
};
