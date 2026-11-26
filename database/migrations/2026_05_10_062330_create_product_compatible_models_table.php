<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table linking toners/inks to the printer models they are compatible with.
     */
    public function up(): void
    {
        Schema::create('product_compatible_models', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('printer_model_id')->constrained('printer_models')->cascadeOnDelete();
            $table->primary(['product_id', 'printer_model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_compatible_models');
    }
};
