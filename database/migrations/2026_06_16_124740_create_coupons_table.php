// database/migrations/2026_06_16_000019_create_coupons_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percentage', 'free_shipping']);
            $table->decimal('value', 15, 2);
            $table->decimal('min_order_amount', 15, 2)->default(0.00);
            $table->decimal('max_discount', 15, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('per_user_limit')->default(1);
            $table->integer('used_count')->default(0);
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->enum('applies_to', ['all', 'products', 'categories'])->default('all');
            $table->json('product_ids')->nullable();
            $table->json('category_ids')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('code');
            $table->index('is_active');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
