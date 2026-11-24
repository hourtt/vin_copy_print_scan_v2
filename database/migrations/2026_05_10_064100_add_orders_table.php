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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Foreign key to users table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('order_date');
            $table->timestamp('shipped_time')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);

            // Foreign key to vouchers table
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->onDelete('set null');
            $table->decimal('applied_voucher_discount', 10, 2)->default(0);

            // Shipping
            $table->foreignId('shipping_method_id')->nullable()->constrained('shipping_methods')->onDelete('set null');
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->text('shipping_address')->nullable();     // snapshot of address at order time
            $table->date('estimated_delivery_date')->nullable();
            $table->text('tracking_notes')->nullable();       // admin notes per status update

            $table->decimal('total', 10, 2);

            // Full delivery tracking status set
            $table->enum('status', [
                'pending',
                'processing',
                'packed',
                'out_for_delivery',
                'delivered',
                'cancelled',
            ])->default('pending');

            // Admin audit trail
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
