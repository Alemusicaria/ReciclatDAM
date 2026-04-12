<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class LogicCheckerPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('scout.driver', 'null');
    }

    public function test_admin_can_open_logic_checker_page(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->get(route('admin.logic-checker'));

        $response
            ->assertOk()
            ->assertSee('Diagnòstic de lògica');
    }

    public function test_admin_can_run_logic_checker_and_get_summary(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->postJson(route('admin.logic-checker.run'), [
            'locale' => 'ca',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'summary' => ['total', 'ok', 'redirect', 'client_error', 'server_error', 'protected_auth', 'protected_csrf', 'expected_validation', 'expected_not_found', 'exceptions', 'skipped'],
                'results',
            ]);

        $results = $response->json('results') ?? [];

        $hasLocalizedRoutes = collect($results)->contains(function (array $row): bool {
            return str_starts_with((string) ($row['route'] ?? ''), 'localized.');
        });

        $this->assertFalse($hasLocalizedRoutes, 'Default checker run should not include localized.* routes.');
    }

    public function test_running_logic_checker_does_not_logout_admin(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->postJson(route('admin.logic-checker.run'), [
            'locale' => 'ca',
        ]);

        $response->assertOk();
        $this->assertAuthenticatedAs($admin);
    }

    private function createAdminUser(): User
    {
        $rol = Rol::query()->firstOrCreate(['nom' => 'admin']);
        $nivell = Nivell::query()->firstOrCreate(
            ['id' => 1],
            [
                'nom' => 'Inicial',
                'punts_requerits' => 0,
                'descripcio' => 'Nivell inicial',
                'icona' => null,
                'color' => '#000000',
            ]
        );

        return User::query()->create([
            'nom' => 'Admin',
            'cognoms' => 'Diag',
            'email' => 'admin.logic.'.uniqid().'@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
