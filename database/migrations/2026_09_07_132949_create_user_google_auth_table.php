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
        Schema::create('user_google_auth', function (Blueprint $table) {
           $table->id();
            $table->string('google_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('avatar')->nullable();
            $table->text('google_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_google_auth');
    }
};
