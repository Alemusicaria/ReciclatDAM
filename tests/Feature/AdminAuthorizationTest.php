<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Rol;
use App\Models\User;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Ensure clean state for Rol and Nivell creation
        Rol::truncate();
        Nivell::truncate();
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = $this->createRegularUser();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_non_admin_cannot_update_admin_data(): void
    {
        $user = $this->createRegularUser();
        $target = $this->createRegularUser('Target');

        $response = $this->actingAs($user)->postJson(route('admin.update', ['type' => 'user', 'id' => $target->id]), [
            'nom' => 'Hacker',
            'cognoms' => 'Test',
            'email' => 'hacker.' . uniqid() . '@reciclat.test',
            'rol_id' => 2,
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    private function createRegularUser(string $prefix = 'Usuari'): User
    {
        $rol = Rol::find(2) ?? Rol::create(['id' => 2, 'nom' => 'usuari']);
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
