<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PrinterModel;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Seed realistic products across all 5 categories.
     * Must run after CategorySeeder and BrandSeeder.
     */
    public function run(): void
    {
        $products = [
            //  Printers 
            ['category' => 'printers', 'brand' => 'HP',      'name' => 'HP LaserJet Pro M404dn',            'price' => 349.00, 'stock' => 12, 'featured' => true,  'specs' => ['Print Speed' => '38 ppm', 'Connectivity' => 'Ethernet, USB', 'Duplex' => 'Automatic', 'Monthly Duty Cycle' => '80,000 pages']],
            ['category' => 'printers', 'brand' => 'HP',      'name' => 'HP LaserJet MFP M428fdw',           'price' => 449.00, 'stock' => 8,  'featured' => true,  'specs' => ['Type' => 'All-in-One', 'Print Speed' => '40 ppm', 'Connectivity' => 'WiFi, Ethernet, USB', 'Duplex' => 'Automatic']],
            ['category' => 'printers', 'brand' => 'Canon',   'name' => 'Canon PIXMA G3020',                 'price' => 189.00, 'stock' => 20, 'featured' => false, 'specs' => ['Type' => 'Inkjet MFP', 'Print Speed' => '11 ipm (B&W)', 'Ink System' => 'Integrated EcoTank', 'Connectivity' => 'WiFi, USB']],
            ['category' => 'printers', 'brand' => 'Canon',   'name' => 'Canon imageCLASS MF445dw',          'price' => 379.00, 'stock' => 6,  'featured' => false, 'specs' => ['Print Speed' => '40 ppm', 'Connectivity' => 'WiFi, USB', 'Duplex' => 'Automatic', 'Display' => '5-inch Color LCD']],
            ['category' => 'printers', 'brand' => 'Brother', 'name' => 'Brother HL-L2350DW',               'price' => 149.00, 'stock' => 25, 'featured' => true,  'specs' => ['Print Speed' => '32 ppm', 'Connectivity' => 'WiFi, USB', 'Duplex' => 'Automatic', 'Resolution' => '2400 x 600 dpi']],
            ['category' => 'printers', 'brand' => 'Brother', 'name' => 'Brother MFC-L2750DW',              'price' => 249.00, 'stock' => 10, 'featured' => false, 'specs' => ['Type' => 'All-in-One', 'Print Speed' => '36 ppm', 'Connectivity' => 'WiFi, Ethernet, USB', 'ADF' => '50-sheet']],
            ['category' => 'printers', 'brand' => 'Epson',   'name' => 'Epson EcoTank L3250',               'price' => 219.00, 'stock' => 15, 'featured' => false, 'specs' => ['Type' => 'Inkjet MFP', 'Ink System' => 'EcoTank', 'Connectivity' => 'WiFi, USB', 'Scan Resolution' => '1200 dpi']],

            //  Toners 
            ['category' => 'toners', 'brand' => 'HP',      'name' => 'HP 26A Black Toner (CF226A)',         'price' => 89.00,  'stock' => 40, 'featured' => true,  'specs' => ['Yield' => '3,100 pages', 'Color' => 'Black', 'Compatible Printers' => 'M402, M426 series']],
            ['category' => 'toners', 'brand' => 'HP',      'name' => 'HP 58A Black Toner (CF258A)',         'price' => 79.00,  'stock' => 35, 'featured' => false, 'specs' => ['Yield' => '3,000 pages', 'Color' => 'Black', 'Compatible Printers' => 'M404, M428 series']],
            ['category' => 'toners', 'brand' => 'HP',      'name' => 'HP 26X High Yield Toner (CF226X)',    'price' => 125.00, 'stock' => 20, 'featured' => false, 'specs' => ['Yield' => '9,000 pages', 'Color' => 'Black', 'Compatible Printers' => 'M402, M426 series']],
            ['category' => 'toners', 'brand' => 'Canon',   'name' => 'Canon Cartridge 054 Black',           'price' => 95.00,  'stock' => 30, 'featured' => false, 'specs' => ['Yield' => '1,500 pages', 'Color' => 'Black', 'Compatible Printers' => 'MF445, MF455 series']],
            ['category' => 'toners', 'brand' => 'Canon',   'name' => 'Canon Cartridge 054H High Yield',     'price' => 130.00, 'stock' => 18, 'featured' => false, 'specs' => ['Yield' => '3,100 pages', 'Color' => 'Black', 'Compatible Printers' => 'MF445, MF455 series']],
            ['category' => 'toners', 'brand' => 'Brother', 'name' => 'Brother TN-2480 Toner',               'price' => 55.00,  'stock' => 50, 'featured' => true,  'specs' => ['Yield' => '3,000 pages', 'Color' => 'Black', 'Compatible Printers' => 'HL-L2350, MFC-L2750 series']],
            ['category' => 'toners', 'brand' => 'Brother', 'name' => 'Brother TN-2430 Standard Toner',      'price' => 45.00,  'stock' => 45, 'featured' => false, 'specs' => ['Yield' => '1,200 pages', 'Color' => 'Black', 'Compatible Printers' => 'HL-L2350, MFC-L2750 series']],
            ['category' => 'toners', 'brand' => 'Samsung', 'name' => 'Samsung MLT-D111S Toner',             'price' => 39.00,  'stock' => 22, 'featured' => false, 'specs' => ['Yield' => '1,000 pages', 'Color' => 'Black', 'Compatible Printers' => 'Xpress M2020, M2070 series']],

            //  Ink Cartridges 
            ['category' => 'ink-cartridges', 'brand' => 'HP',    'name' => 'HP 682 Black Ink Cartridge',    'price' => 15.00,  'stock' => 80, 'featured' => true,  'specs' => ['Yield' => '480 pages',   'Color' => 'Black',     'Compatible Printers' => 'DeskJet 2335, 2775, 4175']],
            ['category' => 'ink-cartridges', 'brand' => 'HP',    'name' => 'HP 682 Tri-color Ink Cartridge','price' => 17.00,  'stock' => 75, 'featured' => false, 'specs' => ['Yield' => '200 pages',   'Color' => 'Tri-color', 'Compatible Printers' => 'DeskJet 2335, 2775, 4175']],
            ['category' => 'ink-cartridges', 'brand' => 'Canon', 'name' => 'Canon PG-47 Black Ink',         'price' => 14.00,  'stock' => 60, 'featured' => false, 'specs' => ['Yield' => '400 pages',   'Color' => 'Black',     'Compatible Printers' => 'PIXMA E400, E480, TS307']],
            ['category' => 'ink-cartridges', 'brand' => 'Canon', 'name' => 'Canon CL-57 Color Ink',         'price' => 16.00,  'stock' => 55, 'featured' => false, 'specs' => ['Yield' => '350 pages',   'Color' => 'Color',     'Compatible Printers' => 'PIXMA E400, E480, TS307']],
            ['category' => 'ink-cartridges', 'brand' => 'Epson', 'name' => 'Epson 003 Black Ink Bottle',    'price' => 12.00,  'stock' => 100,'featured' => true,  'specs' => ['Yield' => '7,500 pages', 'Color' => 'Black',     'Compatible Printers' => 'EcoTank L3110, L3150, L3250']],
            ['category' => 'ink-cartridges', 'brand' => 'Epson', 'name' => 'Epson 003 CMY Color Ink Set',   'price' => 38.00,  'stock' => 90, 'featured' => false, 'specs' => ['Yield' => '5,000 pages', 'Color' => 'CMY Set',   'Compatible Printers' => 'EcoTank L3110, L3150, L3250']],

            //  Paper 
            ['category' => 'paper', 'brand' => null, 'name' => 'A4 80gsm Multipurpose Paper (500 sheets)',  'price' => 8.50,   'stock' => 200,'featured' => true,  'specs' => ['Size' => 'A4 (210×297mm)', 'Weight' => '80 gsm', 'Sheets per Ream' => '500', 'Brightness' => '104%']],
            ['category' => 'paper', 'brand' => null, 'name' => 'A4 80gsm Multipurpose Paper (5 Reams)',     'price' => 39.00,  'stock' => 80, 'featured' => false, 'specs' => ['Size' => 'A4 (210×297mm)', 'Weight' => '80 gsm', 'Total Sheets' => '2,500', 'Brightness' => '104%']],
            ['category' => 'paper', 'brand' => null, 'name' => 'A3 80gsm Printing Paper (500 sheets)',      'price' => 16.00,  'stock' => 60, 'featured' => false, 'specs' => ['Size' => 'A3 (297×420mm)', 'Weight' => '80 gsm', 'Sheets per Ream' => '500', 'Brightness' => '102%']],
            ['category' => 'paper', 'brand' => null, 'name' => 'A4 90gsm Premium Paper (500 sheets)',       'price' => 11.00,  'stock' => 120,'featured' => false, 'specs' => ['Size' => 'A4 (210×297mm)', 'Weight' => '90 gsm', 'Sheets per Ream' => '500', 'Finish' => 'Smooth']],
            ['category' => 'paper', 'brand' => null, 'name' => 'A4 Photo Glossy Paper 200gsm (20 sheets)',  'price' => 6.50,   'stock' => 150,'featured' => false, 'specs' => ['Size' => 'A4', 'Weight' => '200 gsm', 'Finish' => 'High Gloss', 'Compatibility' => 'Inkjet Printers']],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category'])->first();
            $brand    = $item['brand'] ? Brand::where('name', $item['brand'])->first() : null;

            if (! $category) {
                continue; // Skip if category doesn't exist (shouldn't happen after CategorySeeder)
            }

            $slug = Str::slug($item['name']);
            // Ensure slug uniqueness
            $existingCount = Product::where('slug', 'like', $slug . '%')->count();
            $uniqueSlug    = $existingCount > 0 ? $slug . '-' . ($existingCount + 1) : $slug;

            Product::firstOrCreate(
                ['slug' => $uniqueSlug],
                [
                    'category_id'    => $category->id,
                    'brand_id'       => $brand?->id,
                    'name'           => $item['name'],
                    'slug'           => $uniqueSlug,
                    'description'    => $this->getDescription($item['category'], $item['name']),
                    'price'          => $item['price'],
                    'stock'          => $item['stock'],
                    'image'          => null,
                    'specifications' => $item['specs'],
                    'is_featured'    => $item['featured'],
                ]
            );
        }

        //  Attach compatible printer models to toners and ink cartridges 
        $this->attachCompatibleModels();
    }

    /**
     * Link toners and inks to their compatible printer models.
     */
    private function attachCompatibleModels(): void
    {
        $compatibilityMap = [
            // HP toners
            'HP 26A Black Toner (CF226A)'      => ['hp-laserjet-pro-m404dn', 'hp-laserjet-mfp-m428fdw'],
            'HP 58A Black Toner (CF258A)'      => ['hp-laserjet-pro-m404dn', 'hp-laserjet-mfp-m428fdw'],
            'HP 26X High Yield Toner (CF226X)' => ['hp-laserjet-pro-m404dn', 'hp-laserjet-mfp-m428fdw'],
            // Canon toners
            'Canon Cartridge 054 Black'        => ['canon-imagecl-ass-mf445dw', 'canon-imagecl-ass-mf455dw'],
            'Canon Cartridge 054H High Yield'  => ['canon-imagecl-ass-mf445dw', 'canon-imagecl-ass-mf455dw'],
            // Brother toners
            'Brother TN-2480 Toner'            => ['brother-hl-l2350dw', 'brother-mfc-l2750dw', 'brother-dcp-l2550dw'],
            'Brother TN-2430 Standard Toner'   => ['brother-hl-l2350dw', 'brother-mfc-l2750dw'],
            // Samsung toners
            'Samsung MLT-D111S Toner'          => ['samsung-xpress-m2020', 'samsung-xpress-m2070', 'samsung-xpress-m2070fw'],
            // HP inks
            'HP 682 Black Ink Cartridge'       => ['hp-deskjet-2335', 'hp-deskjet-2775', 'hp-deskjet-ink-advantage-4175'],
            'HP 682 Tri-color Ink Cartridge'   => ['hp-deskjet-2335', 'hp-deskjet-2775', 'hp-deskjet-ink-advantage-4175'],
            // Canon inks
            'Canon PG-47 Black Ink'            => ['canon-pixma-e400', 'canon-pixma-e480', 'canon-pixma-ts307'],
            'Canon CL-57 Color Ink'            => ['canon-pixma-e400', 'canon-pixma-e480', 'canon-pixma-ts307'],
            // Epson inks
            'Epson 003 Black Ink Bottle'       => ['epson-eco-tank-l3110', 'epson-eco-tank-l3150', 'epson-eco-tank-l3250'],
            'Epson 003 CMY Color Ink Set'      => ['epson-eco-tank-l3110', 'epson-eco-tank-l3150', 'epson-eco-tank-l3250'],
        ];

        foreach ($compatibilityMap as $productName => $modelSlugs) {
            $product = Product::where('name', $productName)->first();
            if (! $product) {
                continue;
            }

            $printerModelIds = \App\Models\PrinterModel::whereIn('slug', $modelSlugs)->pluck('id')->toArray();
            if (! empty($printerModelIds)) {
                $product->compatibleModels()->syncWithoutDetaching($printerModelIds);
            }
        }
    }

    /**
     * Generate a meaningful product description.
     */
    private function getDescription(string $categorySlug, string $productName): string
    {
        $descriptions = [
            'printers'        => "The {$productName} delivers professional-quality printing for demanding office environments. Designed for reliability and speed, it handles high-volume print jobs with ease.",
            'toners'          => "Genuine {$productName} cartridge engineered for optimal performance with compatible printers. Delivers sharp, fade-resistant prints with consistent page yield.",
            'ink-cartridges'  => "The {$productName} produces vibrant colours and crisp black text. Formulated for use with compatible inkjet printers to deliver reliable, smear-resistant output.",
            'paper'           => "{$productName} is ideal for everyday office printing. Acid-free and compatible with laser and inkjet printers for clear, professional documents.",
            'accessories'     => "{$productName} is a quality accessory designed to extend the life and performance of your printing equipment.",
        ];

        return $descriptions[$categorySlug] ?? "Quality {$productName} for professional printing needs.";
    }
}
