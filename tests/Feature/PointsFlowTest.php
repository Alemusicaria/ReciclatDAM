<?php

namespace Tests\Feature;

use App\Models\Codi;
use App\Models\Event;
use App\Models\Nivell;
use App\Models\Premi;
use App\Models\Rol;
use App\Models\TipusEvent;
use App\Models\User;
use Tests\TestCase;

class PointsFlowTest extends TestCase
{
    public function test_user_can_redeem_premi_and_points_are_updated(): void
    {
        $user = $this->createUserWithPoints(100);
        $premi = Premi::query()->create([
            'nom' => 'Premi test ' . uniqid(),
            'descripcio' => 'Premi per validar canje',
            'punts_requerits' => 25,
            'imatge' => 'images/Premis/test.jpg',
        ]);

        $response = $this->actingAs($user)->postJson(route('premis.canjear', $premi->id));

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $user->refresh();

        $this->assertSame(75, (int) $user->punts_actuals);
        $this->assertSame(25, (int) $user->punts_gastats);
    }

    public function test_user_can_process_code_and_points_are_updated(): void
    {
        $user = $this->createUserWithPoints(10);

        $response = $this->actingAs($user)->postJson(route('process-code'), [
            'code' => 'TESTCODE-' . uniqid(),
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'points', 'new_total', 'message']);

        $user->refresh();

        $this->assertGreaterThan(10, (int) $user->punts_actuals);
        $this->assertGreaterThan(10, (int) $user->punts_totals);
    }

    private function createUserWithPoints(int $points): User
    {
        $rol = Rol::query()->firstOrCreate(['nom' => 'usuari']);
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
            'nom' => 'Usuari',
            'cognoms' => 'Punts',
            'email' => 'user.points.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => $points,
            'punts_actuals' => $points,
            'punts_gastats' => 0,
        ]);
    }
}
