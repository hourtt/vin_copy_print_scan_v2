<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Foreign key to categories table
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            // Foreign key to brands table (nullable — not all products may have a brand)
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->unsignedInteger('sales_count')->default(0)->index();
            $table->string('image')->nullable();          // primary/thumbnail image path
            $table->json('specifications')->nullable();   // e.g. {"Print Speed":"30ppm","Connectivity":"WiFi"}
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'brand_id', 'deleted_at'], 'idx_products_cat_brand_deleted');
            $table->index(['is_featured', 'stock', 'deleted_at'], 'idx_products_featured_stock');
            $table->index(['discount_price', 'sales_count', 'deleted_at'], 'idx_products_discount_sales');
            $table->index('price', 'idx_products_price');
            $table->index('stock', 'idx_products_stock');
            $table->index('deleted_at', 'idx_products_deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
