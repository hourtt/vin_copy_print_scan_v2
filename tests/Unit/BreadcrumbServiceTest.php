<?php

namespace Tests\Unit;

use App\Services\BreadcrumbService;
use Tests\TestCase;

class BreadcrumbServiceTest extends TestCase
{
    public function test_get_for_cart_from_icon_returns_only_dashboard_and_cart(): void
    {
        $service = new BreadcrumbService();
        $service->push('Papers', 'http://localhost/papers');

        $breadcrumbs = $service->getForCart(true);

        $this->assertCount(2, $breadcrumbs);
        $this->assertEquals('Dashboard', $breadcrumbs[0]['label']);
        $this->assertEquals('Shopping Cart', $breadcrumbs[1]['label']);
    }

    public function test_get_for_cart_from_browsing_returns_last_stack_entry(): void
    {
        $service = new BreadcrumbService();
        $service->push('Papers', 'http://localhost/papers');

        $breadcrumbs = $service->getForCart(false);

        $this->assertCount(3, $breadcrumbs);
        $this->assertEquals('Dashboard', $breadcrumbs[0]['label']);
        $this->assertEquals('Papers', $breadcrumbs[1]['label']);
        $this->assertEquals('Shopping Cart', $breadcrumbs[2]['label']);
    }
}
