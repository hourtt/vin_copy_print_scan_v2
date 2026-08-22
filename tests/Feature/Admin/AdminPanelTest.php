<?php

namespace Tests\Feature\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.dashboard'));
        $response->assertRedirect(route('dashboard'));
    }

    public function test_admin_dashboard_loads_successfully(): void
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

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Total Inquiries');
        $response->assertSee('Recent Inquiries');
    }

    public function test_admin_products_index_and_crud(): void
    {
        $category = Category::factory()->create(['name' => 'Printers']);
        $brand = Brand::factory()->create(['name' => 'HP']);
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => 'HP LaserJet Pro',
            'slug' => 'hp-laserjet-pro',
            'price' => 299.99,
            'stock' => 15,
        ]);

        // Index
        $response = $this->actingAs($this->admin)->get(route('admin.products.index'));
        $response->assertStatus(200);
        $response->assertSee('HP LaserJet Pro');

        // Create page
        $responseCreate = $this->actingAs($this->admin)->get(route('admin.products.create'));
        $responseCreate->assertStatus(200);

        // Store
        $responseStore = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Canon Pixma TS',
            'price' => 120.00,
            'stock' => 10,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'status' => 'active',
        ]);
        $responseStore->assertRedirect();
        $this->assertDatabaseHas('products', ['name' => 'Canon Pixma TS']);

        // Show page
        $responseShow = $this->actingAs($this->admin)->get(route('admin.products.show', $product));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('HP LaserJet Pro');

        // Edit page
        $responseEdit = $this->actingAs($this->admin)->get(route('admin.products.edit', $product));
        $responseEdit->assertStatus(200);

        // Update
        $responseUpdate = $this->actingAs($this->admin)->put(route('admin.products.update', $product), [
            'name' => 'HP LaserJet Pro Max',
            'price' => 349.99,
            'stock' => 20,
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'status' => 'active',
        ]);
        $responseUpdate->assertRedirect(route('admin.products.edit', $product));
        $this->assertDatabaseHas('products', ['name' => 'HP LaserJet Pro Max']);

        // Toggle featured
        $responseToggle = $this->actingAs($this->admin)->patchJson(route('admin.products.toggle-featured', $product));
        $responseToggle->assertStatus(200);
        $responseToggle->assertJson(['is_featured' => true]);

        // Archive / Soft delete
        $responseDelete = $this->actingAs($this->admin)->delete(route('admin.products.destroy', $product));
        $responseDelete->assertRedirect();
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_admin_categories_index_and_crud(): void
    {
        $category = Category::factory()->create(['name' => 'Scanners', 'slug' => 'scanners']);

        // Index
        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));
        $response->assertStatus(200);
        $response->assertSee('Scanners');

        // Create page
        $responseCreate = $this->actingAs($this->admin)->get(route('admin.categories.create'));
        $responseCreate->assertStatus(200);

        // Store
        $responseStore = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Copiers',
            'slug' => 'copiers',
            'sort_order' => 1,
        ]);
        $responseStore->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Copiers']);

        // Edit page
        $responseEdit = $this->actingAs($this->admin)->get(route('admin.categories.edit', $category));
        $responseEdit->assertStatus(200);

        // Update
        $responseUpdate = $this->actingAs($this->admin)->put(route('admin.categories.update', $category), [
            'name' => 'Document Scanners',
            'slug' => 'scanners',
            'sort_order' => 2,
        ]);
        $responseUpdate->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Document Scanners']);

        // Category products page
        $responseProducts = $this->actingAs($this->admin)->get(route('admin.categories.products', $category));
        $responseProducts->assertStatus(200);

        // Delete
        $responseDelete = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category));
        $responseDelete->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_customers_index_and_show(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        Inquiry::create([
            'user_id' => $this->customer->id,
            'product_id' => $product->id,
            'user_name_snapshot' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'user_email_snapshot' => $this->customer->email,
            'product_name_snapshot' => $product->name,
            'product_price_snapshot' => $product->price,
            'language' => 'en',
            'message' => 'Need quote',
        ]);

        // Customers list
        $response = $this->actingAs($this->admin)->get(route('admin.customers.index'));
        $response->assertStatus(200);
        $response->assertSee($this->customer->email);
        $response->assertSee('Inquiries');

        // Customer show
        $responseShow = $this->actingAs($this->admin)->get(route('admin.customers.show', $this->customer));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Total Inquiries');
        $responseShow->assertSee('Inquiry History');

        // Toggle status
        $responseToggle = $this->actingAs($this->admin)->patch(route('admin.customers.toggle-status', $this->customer));
        $responseToggle->assertRedirect();
        $this->assertTrue($this->customer->fresh()->is_banned);
    }

    public function test_admin_inquiries_index_and_pdf_export(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        Inquiry::create([
            'user_id' => $this->customer->id,
            'product_id' => $product->id,
            'user_name_snapshot' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'user_email_snapshot' => $this->customer->email,
            'product_name_snapshot' => $product->name,
            'product_price_snapshot' => $product->price,
            'language' => 'en',
            'message' => 'Price inquiry',
        ]);

        // Inquiries index
        $response = $this->actingAs($this->admin)->get(route('admin.inquiries.index'));
        $response->assertStatus(200);
        $response->assertSee('Inquiry Log');
        $response->assertSee($product->name);

        // Export PDF
        $responseExport = $this->actingAs($this->admin)->get(route('admin.inquiries.export'));
        $responseExport->assertStatus(200);
        $this->assertEquals('application/pdf', $responseExport->headers->get('content-type'));
    }

    public function test_admin_settings_index_and_updates(): void
    {
        // Settings page
        $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
        $response->assertSee('Store Configuration');
        $response->assertSee('Personal Details');

        // Update shop config
        $responseShop = $this->actingAs($this->admin)->patch(route('admin.settings.update-shop'), [
            'shop_name' => 'Updated Shop Name',
            'shop_email' => 'contact@testshop.com',
            'shop_phone' => '012345678',
            'shop_address' => 'Phnom Penh, Cambodia',
            'shop_description' => 'Best printer shop in town',
        ]);
        $responseShop->assertRedirect();
        $this->assertDatabaseHas('shop_settings', ['key' => 'shop_name', 'value' => 'Updated Shop Name']);

        // Update admin profile
        $responseProfile = $this->actingAs($this->admin)->patch(route('admin.settings.update-admin'), [
            'first_name' => 'Master',
            'last_name' => 'Admin',
            'email' => $this->admin->email,
        ]);
        $responseProfile->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'first_name' => 'Master', 'last_name' => 'Admin']);
    }
}
