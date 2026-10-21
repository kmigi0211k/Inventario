<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $normalUser;
    protected $adminRole;
    protected $userRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRole = Role::create(['description' => 'Admin', 'status' => 1]);
        $this->userRole = Role::create(['description' => 'User', 'status' => 1]);

        $this->adminUser = User::factory()->create(['role_id' => $this->adminRole->id]);
        $this->normalUser = User::factory()->create(['role_id' => $this->userRole->id]);
    }

    /** @test */
    public function un_administrador_ve_el_dashboard_y_aparecen_los_indicadores()
    {
        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Panel General');
        $response->assertSee('Total Productos');
        $response->assertSee('Alertas de Stock');
        $response->assertSee('Valor del Inventario');
        $response->assertSee('Usuarios Registrados');
        $response->assertSee(route('products.dashboard'));
        $response->assertSee(route('products.create'));
        $response->assertSee(route('admin.users'));
    }

    /** @test */
    public function un_usuario_normal_no_puede_entrar()
    {
        $response = $this->actingAs($this->normalUser)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    /** @test */
    public function un_visitante_es_redirigido_al_login()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function los_conteos_son_correctos_con_datos_de_prueba()
    {
        // Producto 1: Activo, stock normal, con precio
        Product::factory()->create([
            'name' => 'Producto Normal',
            'is_active' => true,
            'stock' => 10,
            'price' => 1000.00,
        ]);

        // Producto 2: Activo, stock bajo (entre 1 y 5), con precio
        Product::factory()->create([
            'name' => 'Producto Stock Bajo Activo',
            'is_active' => true,
            'stock' => 3,
            'price' => 2000.00,
        ]);

        // Producto 3: Activo, agotado (stock 0), con precio
        Product::factory()->create([
            'name' => 'Producto Agotado',
            'is_active' => true,
            'stock' => 0,
            'price' => 5000.00,
        ]);

        // Producto 4: Inactivo, stock bajo (stock 4), con precio (no suma al valor de inventario)
        Product::factory()->create([
            'name' => 'Producto Inactivo',
            'is_active' => false,
            'stock' => 4,
            'price' => 1500.00,
        ]);

        // Producto 5: Activo, stock bajo (stock 2), sin precio (precio null tratado como 0)
        Product::factory()->create([
            'name' => 'Producto Precio Null',
            'is_active' => true,
            'stock' => 2,
            'price' => null,
        ]);

        // Creamos un segundo usuario normal para tener 1 admin y 2 normales = 3 usuarios en total
        User::factory()->create(['role_id' => $this->userRole->id]);

        $response = $this->actingAs($this->adminUser)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);

        // Verificamos las variables pasadas a la vista
        $response->assertViewHas('totalProducts', 5);
        $response->assertViewHas('activeProducts', 4);
        $response->assertViewHas('inactiveProducts', 1);
        $response->assertViewHas('lowStockProducts', 3); // productos 2, 4, 5
        $response->assertViewHas('outOfStockProducts', 1); // producto 3
        // Valor: (10 * 1000) + (3 * 2000) + (0 * 5000) + (2 * 0) = 10000 + 6000 = 16000
        $response->assertViewHas('totalInventoryValue', 16000.0);
        $response->assertViewHas('totalUsers', 3);
        $response->assertViewHas('adminUsers', 1);
        $response->assertViewHas('regularUsers', 2);

        // Verificamos formato COP en el HTML
        $response->assertSee('$16.000');
    }

    /** @test */
    public function el_dashboard_de_productos_sigue_respondiendo()
    {
        Product::factory()->create(['name' => 'Producto Demo']);

        $response = $this->actingAs($this->adminUser)
                         ->get(route('products.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Panel de Control');
        $response->assertSee('Producto Demo');
        $response->assertSee(route('admin.dashboard')); // Enlace de regreso al panel general
    }
}
