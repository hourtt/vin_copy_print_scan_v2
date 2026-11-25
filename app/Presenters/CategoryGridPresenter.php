<?php

namespace App\Presenters;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryGridPresenter
{
    /**
     * Build the grid configuration array for components.products._grid.
     *
     * @return array<string, mixed>
     */
    public function present(LengthAwarePaginator $products, Category $category): array
    {
        $defaults = config("catalog.grid_defaults.{$category->type->value}")
            ?? config('catalog.grid_defaults.default', [
                'groupBy' => 'brand_id',
                'headingRelation' => 'brand',
                'headingFallback' => 'Other',
                'subLabelRelation' => 'brand',
                'subLabelFallback' => 'Product',
                'compatKey' => 'compatibility',
                'badgeCase' => 'uppercase',
            ]);

        return [
            'products' => $products,
            ...$defaults,
            'emptyMessage' => "No {$category->name} found.",
        ];
    }
}
