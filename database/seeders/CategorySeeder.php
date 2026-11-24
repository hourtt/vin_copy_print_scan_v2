<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the 5 product categories for this shop.
     * Must run before BrandSeeder and ProductSeeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Printers',
                'slug' => 'printers',
                'description' => 'Laser and inkjet printers for home and office use.',
                'icon' => 'printer',
                'sort_order' => 1,
            ],
            [
                'name' => 'Toners',
                'slug' => 'toners',
                'description' => 'Laser toner cartridges compatible with a wide range of printer models.',
                'icon' => 'toner',
                'sort_order' => 2,
            ],
            [
                'name' => 'Ink Cartridges',
                'slug' => 'ink-cartridges',
                'description' => 'Inkjet ink cartridges for vivid colour and crisp black prints.',
                'icon' => 'ink',
                'sort_order' => 3,
            ],
            [
                'name' => 'Papers',
                'slug' => 'papers',
                'description' => 'High-quality A3 and A4 printing paper for all print volumes.',
                'icon' => 'paper',
                'sort_order' => 4,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Cables, maintenance kits, and other printing accessories.',
                'icon' => 'accessories',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
