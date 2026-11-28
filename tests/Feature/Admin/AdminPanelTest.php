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

    public function test_admin_can_access_filament_brands_and_printer_models_resources(): void
    {
        $this->actingAs($this->admin)
            ->get('/vin_admin_print_scan_dashboard/brands')
            ->assertStatus(200);

        $this->actingAs($this->admin)
            ->get('/vin_admin_print_scan_dashboard/printer-models')
            ->assertStatus(200);

        $this->actingAs($this->admin)
            ->get('/vin_admin_print_scan_dashboard/products/create')
            ->assertStatus(200);
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

    public function test_admin_can_access_filament_profile_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/vin_admin_print_scan_dashboard/profile');
        $response->assertStatus(200);
    }

    public function test_admin_is_blocked_from_public_storefront_and_customer_pages(): void
    {
        $responseHome = $this->actingAs($this->admin)->get('/');
        $responseHome->assertRedirect('/vin_admin_print_scan_dashboard');

        $responseCatalog = $this->actingAs($this->admin)->get('/product-catalog');
        $responseCatalog->assertRedirect('/vin_admin_print_scan_dashboard');

        $responseServices = $this->actingAs($this->admin)->get('/services');
        $responseServices->assertRedirect('/vin_admin_print_scan_dashboard');

        $responseCustomerProfile = $this->actingAs($this->admin)->get('/profile');
        $responseCustomerProfile->assertRedirect('/vin_admin_print_scan_dashboard');
    }

    public function test_customer_without_profile_image_generates_initial_avatar(): void
    {
        $jenni = User::factory()->create([
            'first_name' => 'Jenni',
            'last_name' => 'Doe',
            'profile_image' => null,
        ]);

        $this->assertStringStartsWith('data:image/svg+xml;base64,', $jenni->avatar_url);
        $svgContent = base64_decode(substr($jenni->avatar_url, strlen('data:image/svg+xml;base64,')));
        $this->assertStringContainsString('J', $svgContent);
    }

    public function test_customer_with_profile_image_returns_stored_avatar_url(): void
    {
        $uploaded = User::factory()->create([
            'first_name' => 'Alex',
            'profile_image' => 'profile_images/alex.jpg',
        ]);

        $this->assertStringContainsString('profile_images/alex.jpg', $uploaded->avatar_url);
    }
}
