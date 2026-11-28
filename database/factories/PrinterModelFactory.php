<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\PrinterModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PrinterModel>
 */
class PrinterModelFactory extends Factory
{
    public function definition(): array
    {
        $modelName = fake()->unique()->bothify('LaserJet ??-###');

        return [
            'brand_id' => Brand::factory(),
            'model_name' => $modelName,
            'slug' => Str::slug($modelName),
        ];
    }
}
