<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create the Admin role required by IsAdmin middleware
        $adminRole = \App\Models\Role::create(['description' => 'Admin', 'status' => 1]);
        $this->user = User::factory()->create(['role_id' => $adminRole->id]);
    }

    /** @test */
    public function un_usuario_autenticado_puede_ver_el_listado_de_productos()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function un_usuario_autenticado_puede_crear_un_producto_con_imagen()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('product.jpg');

        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 100.50,
            'stock' => 10,
            'image' => $file,
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.dashboard'));
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
        
        // Verify image storage
        $product = Product::where('name', 'Test Product')->first();
        Storage::disk('public')->assertExists($product->image);
    }

    /** @test */
    public function la_creacion_de_un_producto_requiere_datos_validos()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('products.store'), [
                             'name' => '',
                             'price' => -10, // Invalid price
                         ]);

        $response->assertSessionHasErrors(['name', 'price']);
    }
}
