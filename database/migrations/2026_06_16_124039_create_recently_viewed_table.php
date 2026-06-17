// database/migrations/2026_06_16_000011_create_recently_viewed_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recently_viewed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->unique(['user_id', 'product_id']);
            $table->index('user_id');
            $table->index('viewed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recently_viewed');
    }
};
