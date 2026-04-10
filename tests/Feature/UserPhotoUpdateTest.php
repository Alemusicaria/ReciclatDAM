<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserPhotoUpdateTest extends TestCase
{
    public function test_user_can_update_profile_photo(): void
    {
        Storage::fake('public');

        $user = $this->createUser();

        $response = $this->actingAs($user)->postJson(route('users.update.photo', $user->id), [
            'foto_perfil' => UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg'),
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'path', 'message']);

        $user->refresh();

        $this->assertNotEmpty($user->foto_perfil);
        Storage::disk('public')->assertExists($user->foto_perfil);
    }

    private function createUser(): User
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
            'cognoms' => 'Foto',
            'email' => 'user.photo.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
