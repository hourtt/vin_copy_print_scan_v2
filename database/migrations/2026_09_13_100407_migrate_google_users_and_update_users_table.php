<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Make users.password nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });

        // 1b. Make connected_accounts tokens text to hold large Google tokens
        Schema::table('connected_accounts', function (Blueprint $table) {
            $table->text('provider_token')->nullable()->change();
            $table->text('provider_refresh_token')->nullable()->change();
        });

        // 2. Migrate existing google users
        if (Schema::hasTable('user_google_auth')) {
            $googleUsers = DB::table('user_google_auth')->get();

            foreach ($googleUsers as $gUser) {
                // Check if user exists by email
                $user = DB::table('users')->where('email', $gUser->email)->first();

                if (!$user) {
                    // Create user
                    $nameParts = explode(' ', trim($gUser->name));
                    $firstName = $nameParts[0];
                    $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

                    $userId = DB::table('users')->insertGetId([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $gUser->email,
                        'password' => null, // Password can be null now
                        'profile_image' => $gUser->avatar,
                        'email_verified_at' => $gUser->created_at ?? now(),
                        'created_at' => $gUser->created_at,
                        'updated_at' => $gUser->updated_at,
                    ]);
                } else {
                    $userId = $user->id;
                }

                // Check if connected account already exists
                $connectedExists = DB::table('connected_accounts')
                    ->where('provider_name', 'google')
                    ->where('provider_id', $gUser->google_id)
                    ->exists();

                if (!$connectedExists) {
                    DB::table('connected_accounts')->insert([
                        'user_id' => $userId,
                        'provider_name' => 'google',
                        'provider_id' => $gUser->google_id,
                        'provider_token' => $gUser->google_token,
                        'created_at' => $gUser->created_at,
                        'updated_at' => $gUser->updated_at,
                    ]);
                }
            }

            // 3. Drop user_google_auth table
            Schema::dropIfExists('user_google_auth');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Best effort reversal: we'll just revert the password nullable change.
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
        });
    }
};
