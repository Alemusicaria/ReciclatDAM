<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class SecuritySweepTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('scout.driver', 'null');
        // Ensure clean state for Rol and Nivell creation
        Rol::truncate();
        Nivell::truncate();
    }

    public function test_unauthorized_user_cannot_access_admin_dashboard(): void
    {
        $user = $this->createRegularUser();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->createRegularUser();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_user_cannot_update_another_user_profile(): void
    {
        $user1 = $this->createRegularUser('User1');
        $user2 = $this->createRegularUser('User2');

        $response = $this->actingAs($user1)->putJson(route('users.update', $user2->id), [
            'nom' => 'Hacked',
            'cognoms' => 'User',
            'email' => 'hacked@reciclat.test',
        ]);

        $response->assertStatus(403);

        $user2->refresh();
        $this->assertNotEquals('Hacked', $user2->nom);
    }

    public function test_user_can_update_own_profile(): void
    {
        $user = $this->createRegularUser();

        $response = $this->actingAs($user)->putJson(route('users.update', $user->id), [
            'nom' => 'Updated',
            'cognoms' => 'Name',
            'email' => $user->email,
        ]);

        $response->assertOk();

        $user->refresh();
        $this->assertEquals('Updated', $user->nom);
    }

    public function test_non_admin_cannot_change_role(): void
    {
        $user = $this->createRegularUser();

        $response = $this->actingAs($user)->putJson(route('users.update', $user->id), [
            'nom' => $user->nom,
            'cognoms' => $user->cognoms,
            'email' => $user->email,
            'rol_id' => 1,
        ]);

        $response->assertStatus(422);
        $user->refresh();
        $this->assertFalse($user->isAdmin(), 'Non-admin user should not be able to change role to admin.');
    }

    public function test_login_brute_force_is_throttled(): void
    {
        $response = null;

        for ($i = 0; $i < 15; $i++) {
            $response = $this->post(route('login'), [
                'email' => 'test@reciclat.test',
                'password' => 'wrong-password',
            ]);

            if ($response->status() === 429) {
                break;
            }
        }

        if ($response) {
            $this->assertEquals(429, $response->status(), 'Login endpoint should throttle after excessive attempts.');
        }
    }

    public function test_password_reset_endpoint_is_throttled(): void
    {
        $response = null;

        for ($i = 0; $i < 8; $i++) {
            $response = $this->post(route('password.email'), [
                'email' => 'test@reciclat.test',
            ]);

            if ($response->status() === 429) {
                break;
            }
        }

        if ($response) {
            $this->assertEquals(429, $response->status(), 'Password reset endpoint should throttle after excessive attempts.');
        }
    }

    public function test_set_locale_endpoint_is_throttled(): void
    {
        $response = null;

        for ($i = 0; $i < 35; $i++) {
            $response = $this->postJson(route('set-locale'), [
                'locale' => 'ca',
            ]);

            if ($response->status() === 429) {
                break;
            }
        }

        if ($response) {
            $this->assertEquals(429, $response->status(), 'Set locale endpoint should throttle after excessive attempts.');
        }
    }

    public function test_protected_routes_require_authentication(): void
    {
        $routes = [
            ['method' => 'post', 'name' => 'logout'],
            ['method' => 'post', 'name' => 'clear-session'],
        ];

        foreach ($routes as $route) {
            $method = $route['method'];
            $routeName = $route['name'];

            if ($method === 'post') {
                $response = $this->post(route($routeName));
            } else {
                $response = $this->get(route($routeName));
            }

            $this->assertTrue(
                $response->status() === 302 || $response->status() === 401,
                "Route {$routeName} should require authentication."
            );
        }
    }

    private function createAdminUser(): User
    {
        $rol = Rol::query()->firstOrCreate(['nom' => 'admin']);
        $nivell = Nivell::find(1) ?? Nivell::create([
            'id' => 1,
            'nom' => 'Inicial',
            'punts_requerits' => 0,
            'descripcio' => 'Nivell inicial',
            'icona' => null,
            'color' => '#000000',
        ]);

        return User::query()->create([
            'nom' => 'Admin',
            'cognoms' => 'Test',
            'email' => 'admin.sec.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }

    private function createRegularUser(string $prefix = 'User'): User
    {
        $rol = Rol::query()->firstOrCreate(['nom' => 'usuari']);
        $nivell = Nivell::find(1) ?? Nivell::create([
            'id' => 1,
            'nom' => 'Inicial',
            'punts_requerits' => 0,
            'descripcio' => 'Nivell inicial',
            'icona' => null,
            'color' => '#000000',
        ]);

        return User::query()->create([
            'nom' => $prefix,
            'cognoms' => 'Test',
            'email' => strtolower($prefix) . '.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
