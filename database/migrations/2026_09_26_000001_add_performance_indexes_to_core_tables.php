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
        // 1. Optimize Products Table
        Schema::table('products', function (Blueprint $table) {
            $table->index(['category_id', 'brand_id', 'deleted_at'], 'idx_products_cat_brand_deleted');
            $table->index(['is_featured', 'stock', 'deleted_at'], 'idx_products_featured_stock');
            $table->index(['discount_price', 'sales_count', 'deleted_at'], 'idx_products_discount_sales');
            $table->index('price', 'idx_products_price');
            $table->index('stock', 'idx_products_stock');
            $table->index('deleted_at', 'idx_products_deleted_at');
        });

        // 2. Optimize Inquiries History Table
        Schema::table('inquiries', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_inquiries_user_created');
        });

        // 3. Optimize Favorites Table
        Schema::table('favorites', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id'], 'uq_favorites_user_product');
        });

        // 4. Optimize Categories Table
        Schema::table('categories', function (Blueprint $table) {
            $table->index('sort_order', 'idx_categories_sort_order');
        });

        // 5. Optimize Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'is_banned'], 'idx_users_role_banned');
        });

        // 6. Optimize Security Activity Logs
        Schema::table('security_activity_logs', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'idx_security_logs_user_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_cat_brand_deleted');
            $table->dropIndex('idx_products_featured_stock');
            $table->dropIndex('idx_products_discount_sales');
            $table->dropIndex('idx_products_price');
            $table->dropIndex('idx_products_stock');
            $table->dropIndex('idx_products_deleted_at');
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropIndex('idx_inquiries_user_created');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropUnique('uq_favorites_user_product');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_sort_order');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role_banned');
        });

        Schema::table('security_activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_security_logs_user_created');
        });
    }
};
