// database/migrations/2026_06_16_000006_create_product_variants_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('variant_type'); // size, color, style
            $table->string('variant_value');
            $table->decimal('price_adjustment', 15, 2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->string('sku')->unique();
            $table->timestamps();

            $table->index('product_id');
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
