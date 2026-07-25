<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreadcrumbHistoryTest extends TestCase
{
    public function test_printer_paper_cart_flow(): void
    {
        // 1. Visit Printers
        $response = $this->get(route('products.printers.index'));
        $response->assertStatus(200);
        $response->assertSee('Printers');

        // 2. Visit Papers
        $response = $this->get(route('products.papers.index'));
        $response->assertStatus(200);
        $response->assertSee('Printers');
        $response->assertSee('Papers');

        // 3. Visit Cart
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSee('Papers');

        // 4. Click back to Papers
        $response = $this->get(route('products.papers.index'));
        $response->assertStatus(200);
        $response->assertSee('Printers');
        $response->assertSee('Papers');
    }

    public function test_direct_link_to_cart_falls_back_to_products_catalog(): void
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSee('Products Catalog');
    }

    public function test_filtering_and_sorting_on_same_page_does_not_duplicate_stack(): void
    {
        $this->get(route('products.printers.index'));
        $this->get(route('products.printers.index', ['sort' => 'price-asc']));

        $stack = session('breadcrumb_stack', []);
        $this->assertCount(1, $stack);
        $this->assertEquals('Printers', $stack[0]['label']);
    }
}
