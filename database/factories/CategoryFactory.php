<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The 5 fixed product categories for this shop.
     * Using an index-based approach so each seeder call gets a unique category.
     */
    private static array $categories = [
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
            'name' => 'Paper',
            'slug' => 'paper',
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

    private static int $index = 0;

    public function definition(): array
    {
        $category = self::$categories[self::$index % count(self::$categories)];
        self::$index++;

        return $category;
    }
}
