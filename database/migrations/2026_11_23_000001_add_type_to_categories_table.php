<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('type', 20)->default('printer')->after('slug');
        });

        // Backfill existing categories based on slug
        DB::table('categories')->whereIn('slug', ['paper', 'papers'])->update(['type' => 'paper']);
        DB::table('categories')->whereIn('slug', ['ink-cartridges', 'ink', 'inks'])->update(['type' => 'ink']);
        DB::table('categories')->whereIn('slug', ['toners', 'toner'])->update(['type' => 'toner']);
        DB::table('categories')->whereIn('slug', ['printers', 'printer'])->update(['type' => 'printer']);
        DB::table('categories')->where('slug', 'accessories')->update(['type' => 'accessories']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
