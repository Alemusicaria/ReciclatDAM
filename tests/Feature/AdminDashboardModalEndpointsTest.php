<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Rol;
use App\Models\User;
use Tests\TestCase;

class AdminDashboardModalEndpointsTest extends TestCase
{
    public function test_admin_modal_content_endpoints_return_success(): void
    {
        $admin = $this->createAdminUser();

        $types = [
            'users',
            'events',
            'premis',
            'codis',
            'productes',
            'punt-reciclatge',
            'rols',
            'tipus-alertes',
            'alertes-punts',
            'tipus-events',
            'premis-reclamats',
            'activitats',
            'users-ranking',
            'opinions',
        ];

        foreach ($types as $type) {
            $this->actingAs($admin)
                ->get('/admin/modal-content/' . $type)
                ->assertOk();
        }
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
            'cognoms' => 'Test',
            'email' => 'admin.modal.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
