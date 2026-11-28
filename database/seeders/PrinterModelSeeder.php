<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\PrinterModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrinterModelSeeder extends Seeder
{
    /**
     * Seeds the master compatibility list of printer models per brand.
     *
     * IMPORTANT:
     * - Must run AFTER BrandSeeder and BEFORE ProductSeeder.
     * - These are reference models for compatibility matching, NOT store inventory.
     *   To make a printer buyable, add it to ProductSeeder as well.
     */
    
    public function run(): void
    {
        $models = [
            // HP models
            'HP' => [
                'LaserJet Pro M404dn',
                'LaserJet Pro M404dw',
                'LaserJet MFP M428fdw',
                'LaserJet MFP M428dw',
                'LaserJet Pro M203dw',
                'DeskJet 2335',
                'DeskJet 2775',
                'DeskJet Ink Advantage 4175',
                'OfficeJet Pro 9010',
            ],
            // Canon models
            'Canon' => [
                'imageCLASS MF445dw',
                'imageCLASS MF455dw',
                'imageCLASS LBP162dw',
                'PIXMA G3020',
                'PIXMA G2020',
                'PIXMA E400',
                'PIXMA E480',
                'PIXMA TS307',
            ],
            // Brother models
            'Brother' => [
                'HL-L2350DW',
                'HL-L2375DW',
                'MFC-L2750DW',
                'MFC-L2710DW',
                'DCP-L2550DW',
            ],
            // Epson models
            'Epson' => [
                'EcoTank L3110',
                'EcoTank L3150',
                'EcoTank L3250',
                'EcoTank L5290',
                'WorkForce WF-2830',
            ],
            // Samsung models
            'Samsung' => [
                'Xpress M2020',
                'Xpress M2070',
                'Xpress M2070FW',
                'Xpress M2835DW',
            ],
        ];

        foreach ($models as $brandName => $modelNames) {
            $brand = Brand::where('name', $brandName)->first();
            if (! $brand) {
                continue;
            }

            foreach ($modelNames as $modelName) {
                $slug = Str::slug($brandName.'-'.$modelName);
                PrinterModel::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'brand_id' => $brand->id,
                        'model_name' => $modelName,
                        'slug' => $slug,
                    ]
                );
            }
        }
    }
}
