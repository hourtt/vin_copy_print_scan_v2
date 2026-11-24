<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\Inquiries\Schemas\InquiryInfolist;
use App\Filament\Widgets\RecentInquiriesWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Schemas\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }

    public function test_guest_is_redirected_from_admin_dashboard(): void
    {
        $response = $this->get('/vin_admin_print_scan_dashboard');
        $response->assertRedirect('/vin_admin_print_scan_dashboard/login');
    }

    public function test_admin_filament_breadcrumbs_are_disabled_globally(): void
    {
        $this->assertFalse(Filament::getPanel('admin')->hasBreadcrumbs());
    }

    public function test_admin_inquiry_infolist_is_configured_correctly(): void
    {
        $schema = Schema::make();
        $configured = InquiryInfolist::configure($schema);

        $this->assertNotEmpty($configured->getComponents());
    }

    public function test_old_admin_route_returns_404(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(404);
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->customer)->get('/vin_admin_print_scan_dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_dashboard_loads_successfully_with_widgets(): void
    {
        $category = Category::factory()->create(['name' => 'Printers']);
        $product = Product::factory()->create(['category_id' => $category->id]);
        Inquiry::create([
            'user_id' => $this->customer->id,
            'product_id' => $product->id,
            'user_name_snapshot' => $this->customer->first_name.' '.$this->customer->last_name,
            'user_email_snapshot' => $this->customer->email,
            'product_name_snapshot' => $product->name,
            'product_price_snapshot' => $product->price,
            'language' => 'en',
            'message' => 'Interested in buying',
        ]);

        $response = $this->actingAs($this->admin)->get('/vin_admin_print_scan_dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');

        Livewire::actingAs($this->admin);
        Livewire::test(StatsOverviewWidget::class)
            ->assertSee('Total Inquiries')
            ->assertSee('Active Customers')
            ->assertSee('Total Products')
            ->assertSee('Categories');

        Livewire::test(RecentInquiriesWidget::class)
            ->assertSee('Recent Inquiries');
    }

    public function test_admin_can_access_filament_products_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/vin_admin_print_scan_dashboard/products');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_filament_categories_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/vin_admin_print_scan_dashboard/categories');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_filament_customers_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/vin_admin_print_scan_dashboard/customers');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_filament_inquiries_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/vin_admin_print_scan_dashboard/inquiries');
        $response->assertStatus(200);
    }
}
