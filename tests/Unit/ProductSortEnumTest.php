<?php

namespace Tests\Unit;

use App\Enums\ProductSort;
use PHPUnit\Framework\TestCase;

class ProductSortEnumTest extends TestCase
{
    public function test_from_string_resolves_valid_snake_and_kebab_cases(): void
    {
        $this->assertEquals(ProductSort::PriceAsc, ProductSort::fromString('price_asc'));
        $this->assertEquals(ProductSort::PriceAsc, ProductSort::fromString('price-asc'));
        $this->assertEquals(ProductSort::PriceDesc, ProductSort::fromString('price_desc'));
        $this->assertEquals(ProductSort::PriceDesc, ProductSort::fromString('price-desc'));
        $this->assertEquals(ProductSort::YearDesc, ProductSort::fromString('year-desc'));
        $this->assertEquals(ProductSort::NameAsc, ProductSort::fromString('name-asc'));
        $this->assertEquals(ProductSort::StockDesc, ProductSort::fromString('stock-desc'));
        $this->assertEquals(ProductSort::Newest, ProductSort::fromString('newest'));
    }

    public function test_from_string_falls_back_to_recommended_on_invalid_or_null(): void
    {
        $this->assertEquals(ProductSort::Recommended, ProductSort::fromString(null));
        $this->assertEquals(ProductSort::Recommended, ProductSort::fromString(''));
        $this->assertEquals(ProductSort::Recommended, ProductSort::fromString('arbitrary-sort'));
    }

    public function test_values_returns_all_case_values(): void
    {
        $values = ProductSort::values();
        $acceptedValues = ProductSort::acceptedValues();

        $this->assertContains('recommended', $values);
        $this->assertContains('newest', $values);
        $this->assertContains('price_asc', $values);
        $this->assertContains('price_desc', $values);
        $this->assertContains('price-asc', $acceptedValues);
        $this->assertContains('price-desc', $acceptedValues);
    }
}
