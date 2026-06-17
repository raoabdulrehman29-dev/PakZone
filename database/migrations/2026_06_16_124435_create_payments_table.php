// database/migrations/2026_06_16_000015_create_payments_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->enum('method', ['cod', 'credit_card', 'debit_card', 'paypal', 'jazzcash', 'easypaisa', 'bank_transfer']);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->json('payment_data')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('order_id');
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
