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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('phone_number')->after('shipping_address')->nullable();
            $table->string('address')->after('phone_number')->nullable();
            $table->string('city')->after('address')->nullable();
            $table->string('state_province')->after('city')->nullable();
            $table->string('zip_code')->after('state_province')->nullable();
            $table->text('order_notes')->after('zip_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'address',
                'city',
                'state_province',
                'zip_code',
                'order_notes'
            ]);
        });
    }
};
