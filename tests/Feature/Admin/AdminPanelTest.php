<?php

namespace Tests\Feature\Admin;

use App\Filament\Widgets\RecentInquiriesWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
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
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->customer)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_dashboard_loads_successfully_with_widgets(): void
    {
        $category = Category::factory()->create(['name' => 'Printers']);
        $product = Product::factory()->create(['category_id' => $category->id]);
        Inquiry::create([
            'user_id' => $this->customer->id,
            'product_id' => $product->id,
            'user_name_snapshot' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'user_email_snapshot' => $this->customer->email,
            'product_name_snapshot' => $product->name,
            'product_price_snapshot' => $product->price,
            'language' => 'en',
            'message' => 'Interested in buying',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin');
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
        $response = $this->actingAs($this->admin)->get('/admin/products');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_filament_categories_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/categories');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_filament_customers_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/customers');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_filament_inquiries_resource(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/inquiries');
        $response->assertStatus(200);
    }
}
