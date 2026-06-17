// database/migrations/2026_06_16_000018_create_review_helpful_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_helpful', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['review_id', 'user_id']);
            $table->index('review_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_helpful');
    }
};
