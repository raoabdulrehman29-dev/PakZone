// database/migrations/2026_06_16_000021_create_notification_preferences_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->boolean('email_enabled')->default(true);
            $table->boolean('sms_enabled')->default(true);
            $table->boolean('push_enabled')->default(true);
            $table->boolean('order_updates')->default(true);
            $table->boolean('promotional')->default(true);
            $table->boolean('price_alerts')->default(true);
            $table->boolean('stock_alerts')->default(true);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
