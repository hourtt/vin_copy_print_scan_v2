<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Seed the main printer/office equipment brands.
     * Must run before PrinterModelSeeder and ProductSeeder.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'HP',      'slug' => 'hp'],
            ['name' => 'Canon',   'slug' => 'canon'],
            ['name' => 'Brother', 'slug' => 'brother'],
            ['name' => 'Epson',   'slug' => 'epson'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Ricoh',   'slug' => 'ricoh'],
            ['name' => 'Xerox',   'slug' => 'xerox'],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['slug' => $brand['slug']], $brand);
        }
    }
}
