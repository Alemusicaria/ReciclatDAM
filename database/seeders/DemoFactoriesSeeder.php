<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\AlertaPuntDeRecollida;
use App\Models\Codi;
use App\Models\Event;
use App\Models\NavigatorInfo;
use App\Models\PremiReclamat;
use App\Models\Session;
use App\Models\TipusEvent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoFactoriesSeeder extends Seeder
{
    public function run(): void
    {
        $users = $this->seedUsers();
        $events = $this->seedEvents();
        $this->seedEventParticipants($users, $events);
        $this->seedCodis($users);
        $this->seedAlerts($users);
        $this->seedClaimedPrizes($users);
        $this->seedActivities($users);
        $this->seedNavigatorInfos();
        $this->seedPasswordResetTokens($users);
        $this->seedSessions($users);
    }

    private function seedUsers(): array
    {
        $users = [
            User::factory()->create(['nom' => 'Aina', 'cognoms' => 'Mila', 'email' => 'aina.mila@reciclat.test', 'rol_id' => 1, 'nivell_id' => 4, 'punts_actuals' => 620, 'punts_gastats' => 100, 'ubicacio' => 'Cervera']),
            User::factory()->create(['nom' => 'Marc', 'cognoms' => 'Soler', 'email' => 'marc.soler@reciclat.test', 'rol_id' => 2, 'nivell_id' => 3, 'punts_actuals' => 280, 'punts_gastats' => 40, 'ubicacio' => 'Tàrrega']),
            User::factory()->create(['nom' => 'Laia', 'cognoms' => 'Pujol', 'email' => 'laia.pujol@reciclat.test', 'rol_id' => 2, 'nivell_id' => 2, 'punts_actuals' => 180, 'punts_gastats' => 0, 'ubicacio' => 'Mollerussa']),
            User::factory()->create(['nom' => 'Pau', 'cognoms' => 'Vidal', 'email' => 'pau.vidal@reciclat.test', 'rol_id' => 2, 'nivell_id' => 5, 'punts_actuals' => 1150, 'punts_gastats' => 100, 'ubicacio' => 'Lleida']),
            User::factory()->create(['nom' => 'Mireia', 'cognoms' => 'Ferrer', 'email' => 'mireia.ferrer@reciclat.test', 'rol_id' => 2, 'nivell_id' => 1, 'punts_actuals' => 90, 'punts_gastats' => 0, 'ubicacio' => 'Balaguer']),
            User::factory()->create(['nom' => 'Jordi', 'cognoms' => 'Serra', 'email' => 'jordi.serra@reciclat.test', 'rol_id' => 2, 'nivell_id' => 3, 'punts_actuals' => 340, 'punts_gastats' => 80, 'ubicacio' => 'Guissona']),
            User::factory()->create(['nom' => 'Carla', 'cognoms' => 'Roca', 'email' => 'carla.roca@reciclat.test', 'rol_id' => 2, 'nivell_id' => 1, 'punts_actuals' => 25, 'punts_gastats' => 0, 'ubicacio' => 'Solsona']),
            User::factory()->create(['nom' => 'Nil', 'cognoms' => 'Coma', 'email' => 'nil.coma@reciclat.test', 'rol_id' => 2, 'nivell_id' => 6, 'punts_actuals' => 2500, 'punts_gastats' => 150, 'ubicacio' => "Seu d'Urgell"]),
        ];

        foreach ($users as $user) {
            $user->forceFill(['punts_totals' => $user->punts_actuals + $user->punts_gastats])->save();
        }

        return collect($users)->keyBy('email')->all();
    }

    private function seedEvents(): array
    {
        $tipusRecollidaEspecial = $this->typeId('Recollida Especial');
        $tipusTallers = $this->typeId('Tallers Educatius');
        $tipusCampanya = $this->typeId('Campanya Informativa');

        $events = [
            Event::factory()->create(['nom' => 'Taller de compostatge', 'tipus_event_id' => $tipusRecollidaEspecial, 'lloc' => 'Centre Cívic de Cervera', 'data_inici' => now()->addDays(7), 'data_fi' => now()->addDays(7)->addHours(2), 'actiu' => true]),
            Event::factory()->create(['nom' => 'Jornada de neteja', 'tipus_event_id' => $tipusTallers, 'lloc' => 'Riu Segre', 'data_inici' => now()->addDays(14), 'data_fi' => now()->addDays(14)->addHours(4), 'actiu' => true]),
            Event::factory()->create(['nom' => 'Campanya porta a porta', 'tipus_event_id' => $tipusCampanya, 'lloc' => 'Barris de Lleida', 'data_inici' => now()->addDays(21), 'data_fi' => now()->addDays(21)->addHours(3), 'actiu' => true]),
            Event::factory()->create(['nom' => 'Xerrada sobre residus', 'tipus_event_id' => $tipusTallers, 'lloc' => 'Biblioteca de Tàrrega', 'data_inici' => now()->addDays(10), 'data_fi' => now()->addDays(10)->addHours(2), 'actiu' => true]),
            Event::factory()->create(['nom' => 'Mercat de reutilització', 'tipus_event_id' => $tipusRecollidaEspecial, 'lloc' => 'Plaça de Balaguer', 'data_inici' => now()->addDays(30), 'data_fi' => now()->addDays(30)->addHours(5), 'actiu' => true]),
            Event::factory()->create(['nom' => 'Ruta de recollida selectiva', 'tipus_event_id' => $tipusCampanya, 'lloc' => 'Casal de Guissona', 'data_inici' => now()->addDays(5), 'data_fi' => now()->addDays(5)->addHours(2), 'actiu' => true]),
        ];

        return collect($events)->keyBy('nom')->all();
    }

    private function seedEventParticipants(array $users, array $events): void
    {
        $productIds = DB::table('productes')->pluck('id')->all();

        DB::table('event_user')->insert([
            ['event_id' => $events['Taller de compostatge']->id, 'user_id' => $users['marc.soler@reciclat.test']->id, 'punts' => 10, 'producte_id' => $productIds[0], 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => $events['Taller de compostatge']->id, 'user_id' => $users['laia.pujol@reciclat.test']->id, 'punts' => 10, 'producte_id' => $productIds[1], 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => $events['Jornada de neteja']->id, 'user_id' => $users['pau.vidal@reciclat.test']->id, 'punts' => 15, 'producte_id' => $productIds[2], 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => $events['Campanya porta a porta']->id, 'user_id' => $users['mireia.ferrer@reciclat.test']->id, 'punts' => 20, 'producte_id' => $productIds[3], 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedCodis(array $users): void
    {
        $codes = ['8423102210153', '8423102210154', '4002160092556', '59713142', '8411547001085', '1234567890123'];
        $userKeys = ['aina.mila@reciclat.test', 'marc.soler@reciclat.test', 'laia.pujol@reciclat.test', 'pau.vidal@reciclat.test', 'jordi.serra@reciclat.test', 'nil.coma@reciclat.test'];

        foreach ($codes as $index => $code) {
            Codi::create([
                'user_id' => $users[$userKeys[$index]]->id,
                'codi' => $code,
                'punts' => 10 + ($index * 4),
                'data_escaneig' => now()->subDays(2 + $index),
            ]);
        }
    }

    private function seedAlerts(array $users): void
    {
        $puntIds = DB::table('punts_de_recollida')->pluck('id')->all();
        $tipusIds = DB::table('tipus_alertes')->pluck('id')->all();

        AlertaPuntDeRecollida::create(['user_id' => $users['marc.soler@reciclat.test']->id, 'punt_de_recollida_id' => $puntIds[0], 'tipus_alerta_id' => $tipusIds[0], 'descripció' => 'Contenidor gairebé ple', 'imatge' => 'images/alertes/ple.jpg']);
        AlertaPuntDeRecollida::create(['user_id' => $users['laia.pujol@reciclat.test']->id, 'punt_de_recollida_id' => $puntIds[1], 'tipus_alerta_id' => $tipusIds[1], 'descripció' => 'Porta d’accés trencada', 'imatge' => 'images/alertes/trencat.jpg']);
        AlertaPuntDeRecollida::create(['user_id' => $users['pau.vidal@reciclat.test']->id, 'punt_de_recollida_id' => $puntIds[2], 'tipus_alerta_id' => $tipusIds[2], 'descripció' => 'Hi ha una barrera temporal', 'imatge' => 'images/alertes/acces.jpg']);
        AlertaPuntDeRecollida::create(['user_id' => $users['jordi.serra@reciclat.test']->id, 'punt_de_recollida_id' => $puntIds[3], 'tipus_alerta_id' => $tipusIds[0], 'descripció' => 'Zona amb residus fora del contenidor', 'imatge' => 'images/alertes/ple.jpg']);
    }

    private function seedClaimedPrizes(array $users): void
    {
        $premiIds = DB::table('premis')->pluck('id')->all();

        PremiReclamat::create(['user_id' => $users['marc.soler@reciclat.test']->id, 'premi_id' => $premiIds[4], 'punts_gastats' => 200, 'data_reclamacio' => now()->subDays(20), 'estat' => 'entregat', 'codi_seguiment' => 'TRK-A1B2C3D4', 'comentaris' => 'Enviat correctament']);
        PremiReclamat::create(['user_id' => $users['pau.vidal@reciclat.test']->id, 'premi_id' => $premiIds[5], 'punts_gastats' => 23, 'data_reclamacio' => now()->subDays(15), 'estat' => 'procesant', 'codi_seguiment' => null, 'comentaris' => 'Revisió pendent']);
        PremiReclamat::create(['user_id' => $users['mireia.ferrer@reciclat.test']->id, 'premi_id' => $premiIds[6], 'punts_gastats' => 23, 'data_reclamacio' => now()->subDays(9), 'estat' => 'procesant', 'codi_seguiment' => null, 'comentaris' => 'Faltava confirmació de dades']);
        PremiReclamat::create(['user_id' => $users['nil.coma@reciclat.test']->id, 'premi_id' => $premiIds[0], 'punts_gastats' => 100, 'data_reclamacio' => now()->subDays(5), 'estat' => 'pendent', 'codi_seguiment' => null, 'comentaris' => 'Nova sol·licitud']);
    }

    private function seedActivities(array $users): void
    {
        Activity::create(['user_id' => $users['aina.mila@reciclat.test']->id, 'action' => 'Ha creat un nou usuari: Marta Costa', 'description' => null, 'data' => ['type' => 'user', 'name' => 'Marta Costa']]);
        Activity::create(['user_id' => $users['aina.mila@reciclat.test']->id, 'action' => 'Ha actualitzat el perfil de Pau Vidal', 'description' => null, 'data' => ['type' => 'profile', 'name' => 'Pau Vidal']]);
        Activity::create(['user_id' => $users['aina.mila@reciclat.test']->id, 'action' => 'Ha escanejat el codi 8423102210153 i ha guanyat 100 punts', 'description' => null, 'data' => ['code' => '8423102210153', 'points' => 100]]);
        Activity::create(['user_id' => $users['aina.mila@reciclat.test']->id, 'action' => 'Ha creat un nou event: Taller de compostatge', 'description' => null, 'data' => ['type' => 'event', 'name' => 'Taller de compostatge']]);
        Activity::create(['user_id' => $users['aina.mila@reciclat.test']->id, 'action' => 'Ha creat una nova alerta per al punt de recollida ID: 1', 'description' => null, 'data' => ['type' => 'alert', 'id' => 1]]);
        Activity::create(['user_id' => $users['aina.mila@reciclat.test']->id, 'action' => 'Ha aprovat la sol·licitud de premi #1 per a Marc Soler amb codi de seguiment: TRK-A1B2C3D4', 'description' => null, 'data' => ['id' => 1, 'user' => 'Marc Soler', 'tracking' => 'TRK-A1B2C3D4']]);
    }

    private function seedNavigatorInfos(): void
    {
        NavigatorInfo::factory()->create(['language' => 'ca-ES', 'languages' => json_encode(['ca-ES', 'es-ES']), 'platform' => 'Win32']);
        NavigatorInfo::factory()->create(['language' => 'es-ES', 'languages' => json_encode(['es-ES', 'ca-ES']), 'platform' => 'Linux x86_64']);
    }

    private function seedPasswordResetTokens(array $users): void
    {
        DB::table('password_reset_tokens')->insert([
            ['email' => $users['mireia.ferrer@reciclat.test']->email, 'token' => bcrypt('reset-token-demo'), 'created_at' => now()->subHours(3)],
        ]);
    }

    private function seedSessions(array $users): void
    {
        Session::factory()->create(['user_id' => $users['aina.mila@reciclat.test']->id, 'ip_address' => '127.0.0.1']);
        Session::factory()->create(['user_id' => $users['jordi.serra@reciclat.test']->id, 'ip_address' => '127.0.0.1']);
    }

    private function typeId(string $name): int
    {
        return (int) DB::table('tipus_events')->where('nom', $name)->value('id');
    }
}
