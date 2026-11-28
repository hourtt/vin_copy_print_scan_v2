<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * PRINTER DIRECTORY (Reference List Only — Not for sale)
     * Master list of printer models grouped by Brand, used strictly for compatibility matching.
     * - Includes printers we DO NOT sell (e.g., older models customers still buy ink/toner for).
     * - Does NOT store price or stock.
     * - Flow: Brand -> PrinterModel -> (pivot) -> Compatible Products.
     */
    public function up(): void
    {
        Schema::create('printer_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('model_name');           // e.g. "LaserJet Pro M404dn"
            $table->string('slug')->unique();       // e.g. "hp-laserjet-pro-m404dn"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_models');
    }
};
