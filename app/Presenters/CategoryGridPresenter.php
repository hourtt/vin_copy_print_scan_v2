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
        $isPaper = $category->isPaper();
        $isInk = $category->isInk();
        $isPrinter = $category->isPrinter();

        $subLabelFallback = match (true) {
            $isPaper => 'Paper',
            $isInk => 'Ink',
            $isPrinter => 'Printer',
            default => 'Toner',
        };

        return [
            'products' => $products,
            'groupBy' => $isPaper ? 'category_id' : 'brand_id',
            'headingRelation' => $isPaper ? 'category' : 'brand',
            'headingFallback' => $isPaper ? 'Uncategorized' : 'Other',
            'subLabelRelation' => $isPaper ? 'category' : 'brand',
            'subLabelFallback' => $subLabelFallback,
            'compatKey' => $isInk ? 'spec:Compatible Printers' : 'compatibility',
            'emptyMessage' => "No {$category->name} found.",
            'badgeCase' => $isInk ? 'capitalize' : 'uppercase',
        ];
    }
}
