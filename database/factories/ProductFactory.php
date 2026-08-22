<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Realistic product definitions per category slug.
     */
    private static array $products = [
        //  Printers 
        ['category' => 'printers', 'brand' => 'HP',      'name' => 'HP LaserJet Pro M404dn',       'price' => 349.00, 'specs' => ['Print Speed' => '38 ppm', 'Connectivity' => 'Ethernet, USB', 'Duplex' => 'Automatic']],
        ['category' => 'printers', 'brand' => 'HP',      'name' => 'HP LaserJet MFP M428fdw',      'price' => 449.00, 'specs' => ['Type' => 'All-in-One', 'Print Speed' => '40 ppm', 'Connectivity' => 'WiFi, Ethernet']],
        ['category' => 'printers', 'brand' => 'Canon',   'name' => 'Canon PIXMA G3020',             'price' => 189.00, 'specs' => ['Type' => 'Inkjet MFP', 'Print Speed' => '11 ipm', 'Ink System' => 'EcoTank']],
        ['category' => 'printers', 'brand' => 'Canon',   'name' => 'Canon imageCLASS MF445dw',     'price' => 379.00, 'specs' => ['Print Speed' => '40 ppm', 'Connectivity' => 'WiFi, USB', 'Duplex' => 'Automatic']],
        ['category' => 'printers', 'brand' => 'Brother', 'name' => 'Brother HL-L2350DW',            'price' => 149.00, 'specs' => ['Print Speed' => '32 ppm', 'Connectivity' => 'WiFi, USB', 'Duplex' => 'Automatic']],
        ['category' => 'printers', 'brand' => 'Brother', 'name' => 'Brother MFC-L2750DW',           'price' => 249.00, 'specs' => ['Type' => 'All-in-One', 'Print Speed' => '36 ppm', 'Connectivity' => 'WiFi']],
        ['category' => 'printers', 'brand' => 'Epson',   'name' => 'Epson EcoTank L3250',           'price' => 219.00, 'specs' => ['Type' => 'Inkjet MFP', 'Ink System' => 'EcoTank', 'Connectivity' => 'WiFi, USB']],

        //  Toners 
        ['category' => 'toners', 'brand' => 'HP',      'name' => 'HP 26A Black Toner (CF226A)',    'price' => 89.00,  'specs' => ['Yield' => '3,100 pages', 'Color' => 'Black', 'Compatible' => 'M402, M426']],
        ['category' => 'toners', 'brand' => 'HP',      'name' => 'HP 58A Black Toner (CF258A)',    'price' => 79.00,  'specs' => ['Yield' => '3,000 pages', 'Color' => 'Black', 'Compatible' => 'M404, M428']],
        ['category' => 'toners', 'brand' => 'Canon',   'name' => 'Canon Cartridge 054 Black',      'price' => 95.00,  'specs' => ['Yield' => '1,500 pages', 'Color' => 'Black', 'Compatible' => 'MF445, MF455']],
        ['category' => 'toners', 'brand' => 'Canon',   'name' => 'Canon Cartridge 054H High Yield','price' => 130.00, 'specs' => ['Yield' => '3,100 pages', 'Color' => 'Black', 'Compatible' => 'MF445, MF455']],
        ['category' => 'toners', 'brand' => 'Brother', 'name' => 'Brother TN-2480 Toner',          'price' => 55.00,  'specs' => ['Yield' => '3,000 pages', 'Color' => 'Black', 'Compatible' => 'HL-L2350, MFC-L2750']],
        ['category' => 'toners', 'brand' => 'Brother', 'name' => 'Brother TN-2430 Toner',          'price' => 45.00,  'specs' => ['Yield' => '1,200 pages', 'Color' => 'Black', 'Compatible' => 'HL-L2350, MFC-L2750']],
        ['category' => 'toners', 'brand' => 'Samsung', 'name' => 'Samsung MLT-D111S Toner',        'price' => 39.00,  'specs' => ['Yield' => '1,000 pages', 'Color' => 'Black', 'Compatible' => 'M2020, M2070']],

        //  Ink Cartridges 
        ['category' => 'ink-cartridges', 'brand' => 'HP',    'name' => 'HP 682 Black Ink Cartridge',  'price' => 15.00, 'specs' => ['Yield' => '480 pages',   'Color' => 'Black', 'Compatible' => 'DeskJet 2335, 2775']],
        ['category' => 'ink-cartridges', 'brand' => 'HP',    'name' => 'HP 682 Color Ink Cartridge',  'price' => 17.00, 'specs' => ['Yield' => '200 pages',   'Color' => 'Tri-color', 'Compatible' => 'DeskJet 2335, 2775']],
        ['category' => 'ink-cartridges', 'brand' => 'Canon', 'name' => 'Canon PG-47 Black Ink',       'price' => 14.00, 'specs' => ['Yield' => '400 pages',   'Color' => 'Black', 'Compatible' => 'PIXMA E400, E480']],
        ['category' => 'ink-cartridges', 'brand' => 'Canon', 'name' => 'Canon CL-57 Color Ink',       'price' => 16.00, 'specs' => ['Yield' => '350 pages',   'Color' => 'Color', 'Compatible' => 'PIXMA E400, E480']],
        ['category' => 'ink-cartridges', 'brand' => 'Epson', 'name' => 'Epson 003 Black Ink Bottle',  'price' => 12.00, 'specs' => ['Yield' => '7,500 pages', 'Color' => 'Black', 'Compatible' => 'L3110, L3150, L3250']],
        ['category' => 'ink-cartridges', 'brand' => 'Epson', 'name' => 'Epson 003 Color Ink Set',     'price' => 38.00, 'specs' => ['Yield' => '5,000 pages', 'Color' => 'CMY Set', 'Compatible' => 'L3110, L3150, L3250']],

        //  Paper 
        ['category' => 'paper', 'brand' => null, 'name' => 'A4 80gsm Multipurpose Paper (500 sheets)', 'price' => 8.50,  'specs' => ['Size' => 'A4', 'Weight' => '80 gsm', 'Sheets' => '500']],
        ['category' => 'paper', 'brand' => null, 'name' => 'A4 80gsm Multipurpose Paper (5 Reams)',    'price' => 39.00, 'specs' => ['Size' => 'A4', 'Weight' => '80 gsm', 'Sheets' => '2,500']],
        ['category' => 'paper', 'brand' => null, 'name' => 'A3 80gsm Printing Paper (500 sheets)',     'price' => 16.00, 'specs' => ['Size' => 'A3', 'Weight' => '80 gsm', 'Sheets' => '500']],
        ['category' => 'paper', 'brand' => null, 'name' => 'A4 90gsm Premium Paper (500 sheets)',      'price' => 11.00, 'specs' => ['Size' => 'A4', 'Weight' => '90 gsm', 'Sheets' => '500']],
        ['category' => 'paper', 'brand' => null, 'name' => 'A4 Photo Glossy Paper (20 sheets)',        'price' => 6.50,  'specs' => ['Size' => 'A4', 'Finish' => 'Glossy', 'GSM' => '200']],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $item = self::$products[self::$index % count(self::$products)];
        self::$index++;

        // Resolve category and brand
        $category = Category::where('slug', $item['category'])->first()
                    ?? Category::inRandomOrder()->first();

        $brand = null;
        if ($item['brand']) {
            $brand = Brand::where('name', $item['brand'])->first();
        }

        $name = $item['name'];
        $slug = Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999);

        return [
            'category_id'    => $category->id,
            'brand_id'       => $brand?->id,
            'name'           => $name,
            'slug'           => $slug,
            'description'    => fake()->paragraph(2),
            'price'          => $item['price'],
            'stock'          => fake()->numberBetween(0, 150),
            'image'          => null,
            'specifications' => $item['specs'],
            'is_featured'    => fake()->boolean(20), // 20% chance of being featured
        ];
    }
}
