<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Rol;
use App\Models\User;
use Tests\TestCase;

class UserProfileUpdateTest extends TestCase
{
    public function test_user_can_update_own_profile_basic_fields(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->put(route('users.update', $user->id), [
            'nom' => 'Nom Actualitzat',
            'cognoms' => 'Cognoms Actualitzats',
            'email' => $user->email,
            'data_naixement' => '1999-12-31',
            'telefon' => '600123123',
            'ubicacio' => 'Barcelona',
            'rol_id' => $user->rol_id,
            'punts_actuals' => $user->punts_actuals,
        ]);

        $response
            ->assertRedirect(route('users.show', $user->id))
            ->assertSessionHas('success');

        $user->refresh();

        $this->assertSame('Nom Actualitzat', $user->nom);
        $this->assertSame('Cognoms Actualitzats', $user->cognoms);
        $this->assertSame('1999-12-31', optional($user->data_naixement)->format('Y-m-d'));
        $this->assertSame('600123123', $user->telefon);
        $this->assertSame('Barcelona', $user->ubicacio);
    }

    public function test_password_requires_matching_confirmation_when_present(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->from(route('users.edit', $user->id))->put(route('users.update', $user->id), [
            'nom' => $user->nom,
            'cognoms' => $user->cognoms,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'different-password',
            'rol_id' => $user->rol_id,
            'punts_actuals' => $user->punts_actuals,
        ]);

        $response
            ->assertRedirect(route('users.edit', $user->id))
            ->assertSessionHasErrors('password');
    }

    private function createUser(): User
    {
        $rol = Rol::query()->firstOrCreate(['id' => 1], ['nom' => 'admin']);
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
            'cognoms' => 'Perfil',
            'email' => 'user.profile.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
