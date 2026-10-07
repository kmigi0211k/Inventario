<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pantalla_de_login_se_puede_visualizar(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_los_usuarios_pueden_autenticarse_usando_la_pantalla_de_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'user_name' => $user->user_name,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_los_usuarios_no_pueden_autenticarse_con_una_contrasena_invalida(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'user_name' => $user->user_name,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_los_usuarios_pueden_cerrar_sesion(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
