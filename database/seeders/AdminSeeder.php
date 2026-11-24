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
            ['email' => 'lyengPrinter@gmail.com'],
            [
                'first_name' => 'Eng',
                'last_name' => 'Ly',
                'email' => 'lyengPrinter@gmail.com',
                'password' => bcrypt('lyengPrinter@731946'),
                'role' => 'admin',
            ]
        );
    }
}
