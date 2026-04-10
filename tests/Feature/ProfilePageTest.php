<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Premi;
use App\Models\PremiReclamat;
use App\Models\Rol;
use App\Models\User;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    public function test_profile_page_does_not_render_claimed_prize_modal_or_summary_footer(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get(route('users.show', $user->id));

        $response
            ->assertOk()
            ->assertDontSee('id="claimedPrizeModal"', false)
            ->assertDontSee('id="premiModal-', false)
            ->assertDontSee('id="profileSummaryFooter"', false);
    }

    public function test_profile_page_rows_use_inline_collapse_for_claim_details(): void
    {
        $user = $this->createUser();
        $premi = Premi::query()->create([
            'nom' => 'Premi test',
            'descripcio' => 'Descripcio test',
            'punts_requerits' => 10,
            'imatge' => null,
            'categoria' => 'general',
            'stock' => 5,
            'temps_enviament' => '3-5 dies',
            'rating' => 4.0,
        ]);

        PremiReclamat::query()->create([
            'user_id' => $user->id,
            'premi_id' => $premi->id,
            'punts_gastats' => 10,
            'data_reclamacio' => now(),
            'estat' => 'pendent',
        ]);

        $response = $this->actingAs($user)->get(route('users.show', $user->id));

        $response
            ->assertOk()
            ->assertDontSee('data-premi=', false)
            ->assertDontSee('data-bs-target="#claimedPrizeModal"', false)
            ->assertSee('data-bs-toggle="collapse"', false)
            ->assertSee('id="claim-details-', false);
    }

    private function createUser(): User
    {
        $rol = Rol::query()->firstOrCreate(['nom' => 'usuari']);
        Nivell::query()->firstOrCreate(
            ['id' => 1],
            [
                'nom' => 'Inicial',
                'punts_requerits' => 0,
                'descripcio' => 'Nivell inicial',
                'icona' => 'fas fa-leaf',
                'color' => '#2e7d32',
            ]
        );

        return User::query()->create([
            'nom' => 'Perfil',
            'cognoms' => 'Test',
            'email' => 'profile.test.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
