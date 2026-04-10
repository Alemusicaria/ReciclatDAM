<?php

namespace Tests\Feature;

use App\Models\Nivell;
use App\Models\Premi;
use App\Models\PremiReclamat;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AdminPremiReclamatFlowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Avoid external scout backends while testing claim transitions.
        Config::set('scout.driver', 'null');
    }

    public function test_admin_can_approve_a_pending_claim_and_generate_tracking_code(): void
    {
        $admin = $this->createAdminUser();
        $claim = $this->createClaim('pendent');

        $response = $this->actingAs($admin)
            ->postJson(route('admin.premis-reclamats.approve', $claim->id));

        $response
            ->assertOk()
            ->assertJson(['success' => true]);

        $claim->refresh();

        $this->assertSame('procesant', $claim->estat);
        $this->assertNotNull($claim->codi_seguiment);
        $this->assertStringStartsWith('TRK-', $claim->codi_seguiment);
    }

    public function test_admin_can_reject_a_claim(): void
    {
        $admin = $this->createAdminUser();
        $claim = $this->createClaim('pendent');

        $response = $this->actingAs($admin)
            ->postJson(route('admin.premis-reclamats.reject', $claim->id));

        $response
            ->assertOk()
            ->assertJson(['success' => true]);

        $claim->refresh();

        $this->assertSame('cancelat', $claim->estat);
    }

    public function test_admin_can_mark_processing_claim_as_delivered(): void
    {
        $admin = $this->createAdminUser();
        $claim = $this->createClaim('procesant');

        $response = $this->actingAs($admin)
            ->postJson(route('admin.premis-reclamats.deliver', $claim->id));

        $response
            ->assertOk()
            ->assertJson(['success' => true]);

        $claim->refresh();

        $this->assertSame('entregat', $claim->estat);
    }

    public function test_admin_cannot_mark_pending_claim_as_delivered(): void
    {
        $admin = $this->createAdminUser();
        $claim = $this->createClaim('pendent');

        $response = $this->actingAs($admin)
            ->postJson(route('admin.premis-reclamats.deliver', $claim->id));

        $response
            ->assertStatus(422)
            ->assertJson(['success' => false]);

        $claim->refresh();

        $this->assertSame('pendent', $claim->estat);
    }

    public function test_admin_can_approve_all_pending_claims(): void
    {
        $admin = $this->createAdminUser();
        $pendingA = $this->createClaim('pendent');
        $pendingB = $this->createClaim('pendent');
        $alreadyDelivered = $this->createClaim('entregat');

        $response = $this->actingAs($admin)
            ->postJson(route('admin.premis-reclamats.approve-all'));

        $response
            ->assertOk()
            ->assertJson(['success' => true]);

        $pendingA->refresh();
        $pendingB->refresh();
        $alreadyDelivered->refresh();

        $this->assertSame('procesant', $pendingA->estat);
        $this->assertSame('procesant', $pendingB->estat);
        $this->assertNotNull($pendingA->codi_seguiment);
        $this->assertNotNull($pendingB->codi_seguiment);
        $this->assertSame('entregat', $alreadyDelivered->estat);
    }

    public function test_admin_update_to_processing_generates_tracking_code_when_empty(): void
    {
        $admin = $this->createAdminUser();
        $claim = $this->createClaim('pendent');

        $response = $this->actingAs($admin)
            ->putJson(route('admin.premis-reclamats.update', $claim->id), [
                'estat' => 'procesant',
                'codi_seguiment' => null,
                'comentaris' => 'Canvi manual des d\'admin',
            ]);

        $response
            ->assertOk()
            ->assertJson(['success' => true]);

        $claim->refresh();

        $this->assertSame('procesant', $claim->estat);
        $this->assertNotNull($claim->codi_seguiment);
        $this->assertStringStartsWith('TRK-', $claim->codi_seguiment);
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
            'email' => 'admin.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }

    private function createClaim(string $status): PremiReclamat
    {
        $user = $this->createRegularUser();
        $premi = Premi::query()->create([
            'nom' => 'Premi test ' . uniqid(),
            'descripcio' => 'Premi per validar workflow',
            'punts_requerits' => 25,
            'imatge' => 'images/Premis/test.jpg',
        ]);

        return PremiReclamat::query()->create([
            'user_id' => $user->id,
            'premi_id' => $premi->id,
            'punts_gastats' => 25,
            'estat' => $status,
            'codi_seguiment' => $status === 'procesant' ? 'TRK-' . strtoupper(substr(md5((string) mt_rand()), 0, 8)) : null,
            'comentaris' => null,
        ]);
    }

    private function createRegularUser(): User
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
            'cognoms' => 'Test',
            'email' => 'user.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 100,
            'punts_actuals' => 100,
            'punts_gastats' => 0,
        ]);
    }
}
