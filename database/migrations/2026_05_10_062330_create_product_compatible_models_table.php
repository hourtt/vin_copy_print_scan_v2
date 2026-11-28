<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * COMPATIBILITY BRIDGE (Many-to-Many Pivot Table)
     * Connects sellable supplies (`products`) to the printers they fit (`printer_models`).
     * - One Toner/Ink can fit many Printer Models.
     * - One Printer Model can use many Toners/Inks.
     * - Items like Papers and Printers do not need entries here.
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
