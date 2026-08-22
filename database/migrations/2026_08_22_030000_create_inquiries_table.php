<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Snapshots - accurate even after product rename/reprice/soft-delete
            $table->string('product_name_snapshot');
            $table->decimal('product_price_snapshot', 10, 2);
            $table->string('user_name_snapshot');
            $table->string('user_email_snapshot');
            $table->string('user_phone_snapshot')->nullable();

            // Future: allow customer to add a note
            $table->text('message')->nullable();

            // Language chosen for the Telegram prefill message
            $table->enum('language', ['en', 'km', 'zh'])->default('en');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
