<?php

namespace Tests\Feature;

use App\Services\BreadcrumbTrail;
use Tests\TestCase;

class BreadcrumbTrailTest extends TestCase
{
    public function test_example_a_navigation_and_multi_level_back_arrow(): void
    {
        $trail = app(BreadcrumbTrail::class);
        $trail->reset();

        // 1. Visit Printer (dropdown)
        $this->get(route('products.printers.index'));
        $this->assertEquals(['Printer'], array_column($trail->getStack(), 'label'));

        // 2. Visit Paper (dropdown)
        $this->get(route('products.papers.index'));
        $this->assertEquals(['Printer', 'Paper'], array_column($trail->getStack(), 'label'));

        // 3. Back Arrow Click (from Paper category page)
        $responseBack2 = $this->get(route('breadcrumb.back', ['from' => 'category']));
        $responseBack2->assertRedirect(route('products.printers.index'));
        $this->assertEquals(['Printer'], array_column($trail->getStack(), 'label'));

        // 4. Back Arrow Click (from Printer category page)
        $responseBack3 = $this->get(route('breadcrumb.back', ['from' => 'category']));
        $responseBack3->assertRedirect(route('dashboard'));
        $this->assertEquals([], array_column($trail->getStack(), 'label'));
    }

    public function test_example_c_product_catalog_clears_stack(): void
    {
        $trail = app(BreadcrumbTrail::class);
        $trail->push('Printer', route('products.printers.index'));

        $response = $this->get(route('product-catalog.index'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Product Catalog');
        $this->assertEmpty($trail->getStack());
    }

    public function test_duplicate_category_revisit_does_not_push_duplicate(): void
    {
        $trail = app(BreadcrumbTrail::class);
        $trail->reset();

        $this->get(route('products.printers.index'));
        $this->get(route('products.printers.index'));

        $this->assertCount(1, $trail->getStack());
    }
}
