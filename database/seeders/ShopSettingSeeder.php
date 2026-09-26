<?php

namespace Database\Seeders;

use App\Models\ShopSetting;
use Illuminate\Database\Seeder;

class ShopSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'shop_name' => 'Vin Copy Print Scan',
            'shop_email' => 'vincopy168@gmail.com   ',
            'shop_phone' => '+855 15 693 334',
            'shop_address' => "Village03, Sangkat02, Sihanoukville, Cambodia",
            'shop_description' => 'Your one-stop shop for professional copying, printing, and scanning services. High quality, fast turnaround.',
        ];

        foreach ($settings as $key => $value) {
            ShopSetting::set($key, $value, 'general');
        }
    }
}
