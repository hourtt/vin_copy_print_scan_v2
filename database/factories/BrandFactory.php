<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Real printer/office equipment brands.
     */
    private static array $brands = [
        ['name' => 'HP',      'slug' => 'hp'],
        ['name' => 'Canon',   'slug' => 'canon'],
        ['name' => 'Brother', 'slug' => 'brother'],
        ['name' => 'Epson',   'slug' => 'epson'],
        ['name' => 'Samsung', 'slug' => 'samsung'],
        ['name' => 'Ricoh',   'slug' => 'ricoh'],
        ['name' => 'Xerox',   'slug' => 'xerox'],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $brand = self::$brands[self::$index % count(self::$brands)];
        self::$index++;

        return [
            'name' => $brand['name'],
            'slug' => $brand['slug'],
            'logo' => null,
        ];
    }
}
