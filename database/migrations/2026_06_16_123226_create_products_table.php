<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock')->default(0);
            $table->integer('low_stock_threshold')->default(10);
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->boolean('featured')->default(false);
            $table->boolean('best_seller')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('reviews_count')->default(0);
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('brand_id');
            $table->index('status');
            $table->index('featured');
            $table->index('best_seller');
            $table->index('rating');
            $table->index('price');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
