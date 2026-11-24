<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // * Point the seeder to the Admin
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'first_name' => env('ADMIN_NAME'),
                'last_name' => env('ADMIN_LASTNAME'),
                'email' => env('ADMIN_EMAIL'),
                'password' => bcrypt(env('ADMIN_PASSWORD')),
                'role' => 'admin',
            ]
        );
    }
}
