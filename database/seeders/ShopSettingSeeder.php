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
            'shop_name'        => 'Vin Copy Print Scan V2',
            'shop_email'       => 'contact@vincopy.com',
            'shop_phone'       => '+1 234 567 8900',
            'shop_address'     => "123 Print Street\nPrinting District, CA 90210",
            'shop_description' => 'Your one-stop shop for professional copying, printing, and scanning services. High quality, fast turnaround.',
        ];

        foreach ($settings as $key => $value) {
            ShopSetting::set($key, $value, 'general');
        }
    }
}
