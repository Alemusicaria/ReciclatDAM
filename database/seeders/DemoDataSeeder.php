<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    private array $userIds = [];
    private array $eventIds = [];
    private array $productIds = [];
    private array $tipusEventIds = [];
    private array $tipusAlertaIds = [];
    private array $puntRecollidaIds = [];
    private array $premiIds = [];

    public function run(): void
    {
        $this->seedUsers();
        $this->hydrateReferenceMaps();
        $this->seedEvents();
        $this->hydrateEventMap();
        $this->seedEventUser();
        $this->seedCodis();
        $this->seedAlertes();
        $this->seedPremisReclamats();
        $this->seedActivities();
        $this->seedNavigatorInfos();
        $this->seedPasswordResetTokens();
        $this->seedSessions();
    }

    private function seedUsers(): void
    {
        $password = Hash::make((string) env('DEMO_USER_PASSWORD', 'password'));

        $users = [
            ['id' => 1, 'nom' => 'Aina', 'cognoms' => 'Mila', 'data_naixement' => '2001-04-12', 'telefon' => '600100200', 'ubicacio' => 'Cervera', 'punts_actuals' => 620, 'punts_gastats' => 100, 'email' => 'aina.mila@reciclat.test', 'created_at' => now()->subMonths(6), 'updated_at' => now(), 'rol_id' => 1, 'foto_perfil' => null, 'nivell_id' => 4],
            ['id' => 2, 'nom' => 'Marc', 'cognoms' => 'Soler', 'data_naixement' => '1998-11-03', 'telefon' => '600100201', 'ubicacio' => 'Tàrrega', 'punts_actuals' => 280, 'punts_gastats' => 40, 'email' => 'marc.soler@reciclat.test', 'created_at' => now()->subMonths(4), 'updated_at' => now(), 'rol_id' => 2, 'foto_perfil' => null, 'nivell_id' => 3],
            ['id' => 3, 'nom' => 'Laia', 'cognoms' => 'Pujol', 'data_naixement' => '2003-02-18', 'telefon' => '600100202', 'ubicacio' => 'Mollerussa', 'punts_actuals' => 180, 'punts_gastats' => 0, 'email' => 'laia.pujol@reciclat.test', 'created_at' => now()->subMonths(3), 'updated_at' => now(), 'rol_id' => 2, 'foto_perfil' => null, 'nivell_id' => 2],
            ['id' => 4, 'nom' => 'Pau', 'cognoms' => 'Vidal', 'data_naixement' => '1995-08-27', 'telefon' => '600100203', 'ubicacio' => 'Lleida', 'punts_actuals' => 1150, 'punts_gastats' => 100, 'email' => 'pau.vidal@reciclat.test', 'created_at' => now()->subMonths(8), 'updated_at' => now(), 'rol_id' => 2, 'foto_perfil' => null, 'nivell_id' => 5],
            ['id' => 5, 'nom' => 'Mireia', 'cognoms' => 'Ferrer', 'data_naixement' => '2000-09-14', 'telefon' => '600100204', 'ubicacio' => 'Balaguer', 'punts_actuals' => 90, 'punts_gastats' => 0, 'email' => 'mireia.ferrer@reciclat.test', 'created_at' => now()->subMonths(2), 'updated_at' => now(), 'rol_id' => 2, 'foto_perfil' => null, 'nivell_id' => 1],
            ['id' => 6, 'nom' => 'Jordi', 'cognoms' => 'Serra', 'data_naixement' => '1993-12-06', 'telefon' => '600100205', 'ubicacio' => 'Guissona', 'punts_actuals' => 340, 'punts_gastats' => 80, 'email' => 'jordi.serra@reciclat.test', 'created_at' => now()->subMonths(5), 'updated_at' => now(), 'rol_id' => 2, 'foto_perfil' => null, 'nivell_id' => 3],
        ];

        foreach ($users as &$user) {
            $this->assertUserPointsIntegrity($user['email'], $user['punts_actuals'], $user['punts_gastats']);
            $user['punts_totals'] = $user['punts_actuals'] + $user['punts_gastats'];
            $user['email_verified_at'] = now();
            $user['password'] = $password;
            $user['remember_token'] = Str::random(10);
        }

        DB::table('users')->insert($users);
    }

    private function hydrateReferenceMaps(): void
    {
        $this->userIds = DB::table('users')->pluck('id', 'email')->all();
        $this->productIds = DB::table('productes')->pluck('id', 'nom')->all();
        $this->tipusEventIds = DB::table('tipus_events')->pluck('id', 'nom')->all();
        $this->tipusAlertaIds = DB::table('tipus_alertes')->pluck('id', 'nom')->all();
        $this->puntRecollidaIds = DB::table('punts_de_recollida')->pluck('id', 'nom')->all();
        $this->premiIds = DB::table('premis')->pluck('id', 'nom')->all();
    }

    private function hydrateEventMap(): void
    {
        $this->eventIds = DB::table('events')->pluck('id', 'nom')->all();
    }

    private function seedEvents(): void
    {
        $tipusRecollidaEspecial = $this->requireId($this->tipusEventIds, 'Recollida Especial', 'tipus_events.nom');
        $tipusTallers = $this->requireId($this->tipusEventIds, 'Tallers Educatius', 'tipus_events.nom');
        $tipusCampanya = $this->requireId($this->tipusEventIds, 'Campanya Informativa', 'tipus_events.nom');

        DB::table('events')->insert([
            ['id' => 1, 'nom' => 'Taller de compostatge', 'descripcio' => 'Aprèn a fer compost a casa.', 'data_inici' => now()->addDays(7), 'data_fi' => now()->addDays(7)->addHours(2), 'lloc' => 'Centre Cívic de Cervera', 'tipus_event_id' => $tipusRecollidaEspecial, 'capacitat' => 30, 'punts_disponibles' => 50, 'actiu' => 1, 'imatge' => 'images/events/compostatge.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nom' => 'Jornada de neteja', 'descripcio' => 'Neteja col·lectiva d’un espai natural.', 'data_inici' => now()->addDays(14), 'data_fi' => now()->addDays(14)->addHours(4), 'lloc' => 'Riu Segre', 'tipus_event_id' => $tipusTallers, 'capacitat' => 50, 'punts_disponibles' => 80, 'actiu' => 1, 'imatge' => 'images/events/neteja.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nom' => 'Campanya porta a porta', 'descripcio' => 'Informació sobre reciclatge domiciliari.', 'data_inici' => now()->addDays(21), 'data_fi' => now()->addDays(21)->addHours(3), 'lloc' => 'Barris de Lleida', 'tipus_event_id' => $tipusCampanya, 'capacitat' => 20, 'punts_disponibles' => 60, 'actiu' => 1, 'imatge' => 'images/events/campanya.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nom' => 'Xerrada sobre residus', 'descripcio' => 'Sessió oberta amb torn de preguntes.', 'data_inici' => now()->addDays(10), 'data_fi' => now()->addDays(10)->addHours(2), 'lloc' => 'Biblioteca de Tàrrega', 'tipus_event_id' => $tipusTallers, 'capacitat' => 40, 'punts_disponibles' => 40, 'actiu' => 1, 'imatge' => 'images/events/xerrada.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedEventUser(): void
    {
        $eventCompostatge = $this->requireId($this->eventIds, 'Taller de compostatge', 'events.nom');
        $eventNeteja = $this->requireId($this->eventIds, 'Jornada de neteja', 'events.nom');
        $eventCampanya = $this->requireId($this->eventIds, 'Campanya porta a porta', 'events.nom');

        DB::table('event_user')->insert([
            ['id' => 1, 'event_id' => $eventCompostatge, 'user_id' => $this->requireId($this->userIds, 'marc.soler@reciclat.test', 'users.email'), 'punts' => 10, 'producte_id' => $this->requireId($this->productIds, 'Bolígraf', 'productes.nom'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'event_id' => $eventCompostatge, 'user_id' => $this->requireId($this->userIds, 'laia.pujol@reciclat.test', 'users.email'), 'punts' => 10, 'producte_id' => $this->requireId($this->productIds, 'Càpsules de cafè', 'productes.nom'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'event_id' => $eventNeteja, 'user_id' => $this->requireId($this->userIds, 'pau.vidal@reciclat.test', 'users.email'), 'punts' => 15, 'producte_id' => $this->requireId($this->productIds, 'Cassola', 'productes.nom'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'event_id' => $eventCampanya, 'user_id' => $this->requireId($this->userIds, 'mireia.ferrer@reciclat.test', 'users.email'), 'punts' => 20, 'producte_id' => $this->requireId($this->productIds, 'CD/DVD', 'productes.nom'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedCodis(): void
    {
        DB::table('codis')->insert([
            ['id' => 1, 'user_id' => $this->requireId($this->userIds, 'aina.mila@reciclat.test', 'users.email'), 'codi' => '8423102210153', 'punts' => 100, 'data_escaneig' => now()->subDays(12)],
            ['id' => 2, 'user_id' => $this->requireId($this->userIds, 'marc.soler@reciclat.test', 'users.email'), 'codi' => '8423102210154', 'punts' => 16, 'data_escaneig' => now()->subDays(10)],
            ['id' => 3, 'user_id' => $this->requireId($this->userIds, 'laia.pujol@reciclat.test', 'users.email'), 'codi' => '4002160092556', 'punts' => 12, 'data_escaneig' => now()->subDays(8)],
            ['id' => 4, 'user_id' => $this->requireId($this->userIds, 'pau.vidal@reciclat.test', 'users.email'), 'codi' => '59713142', 'punts' => 19, 'data_escaneig' => now()->subDays(5)],
            ['id' => 5, 'user_id' => $this->requireId($this->userIds, 'jordi.serra@reciclat.test', 'users.email'), 'codi' => '8411547001085', 'punts' => 14, 'data_escaneig' => now()->subDays(2)],
        ]);
    }

    private function seedAlertes(): void
    {
        DB::table('alertes_punts_de_recollida')->insert([
            ['id' => 1, 'user_id' => $this->requireId($this->userIds, 'marc.soler@reciclat.test', 'users.email'), 'punt_de_recollida_id' => $this->requireId($this->puntRecollidaIds, 'Punt Sud', 'punts_de_recollida.nom'), 'tipus_alerta_id' => $this->requireId($this->tipusAlertaIds, 'Capacitat', 'tipus_alertes.nom'), 'descripció' => 'Contenidor gairebé ple', 'imatge' => 'images/alertes/ple.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => $this->requireId($this->userIds, 'laia.pujol@reciclat.test', 'users.email'), 'punt_de_recollida_id' => $this->requireId($this->puntRecollidaIds, 'Punt Central', 'punts_de_recollida.nom'), 'tipus_alerta_id' => $this->requireId($this->tipusAlertaIds, 'Desperfectes', 'tipus_alertes.nom'), 'descripció' => 'Porta d’accés trencada', 'imatge' => 'images/alertes/trencat.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => $this->requireId($this->userIds, 'pau.vidal@reciclat.test', 'users.email'), 'punt_de_recollida_id' => $this->requireId($this->puntRecollidaIds, 'Punt Nord', 'punts_de_recollida.nom'), 'tipus_alerta_id' => $this->requireId($this->tipusAlertaIds, 'Altres', 'tipus_alertes.nom'), 'descripció' => 'Hi ha una barrera temporal', 'imatge' => 'images/alertes/acces.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedPremisReclamats(): void
    {
        DB::table('premis_reclamats')->insert([
            ['id' => 1, 'user_id' => $this->requireId($this->userIds, 'marc.soler@reciclat.test', 'users.email'), 'premi_id' => $this->requireId($this->premiIds, 'motxilla', 'premis.nom'), 'punts_gastats' => 200, 'data_reclamacio' => now()->subDays(20), 'estat' => 'entregat', 'codi_seguiment' => 'TRK-A1B2C3D4', 'comentaris' => 'Enviat correctament', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => $this->requireId($this->userIds, 'pau.vidal@reciclat.test', 'users.email'), 'premi_id' => $this->requireId($this->premiIds, 'provaº', 'premis.nom'), 'punts_gastats' => 23, 'data_reclamacio' => now()->subDays(15), 'estat' => 'procesant', 'codi_seguiment' => null, 'comentaris' => 'Revisió pendent', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => $this->requireId($this->userIds, 'mireia.ferrer@reciclat.test', 'users.email'), 'premi_id' => $this->requireId($this->premiIds, 'holas', 'premis.nom'), 'punts_gastats' => 23, 'data_reclamacio' => now()->subDays(9), 'estat' => 'procesant', 'codi_seguiment' => null, 'comentaris' => 'Faltava confirmació de dades', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    private function seedActivities(): void
    {
        $adminUserId = $this->requireId($this->userIds, 'aina.mila@reciclat.test', 'users.email');

        DB::table('activities')->insert([
            ['id' => 1, 'user_id' => $adminUserId, 'action' => 'Ha creat un nou usuari: Marta Costa', 'description' => null, 'data' => json_encode(['type' => 'user', 'name' => 'Marta Costa']), 'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5)],
            ['id' => 2, 'user_id' => $adminUserId, 'action' => 'Ha actualitzat el perfil de Pau Vidal', 'description' => null, 'data' => json_encode(['type' => 'profile', 'name' => 'Pau Vidal']), 'created_at' => now()->subDays(4), 'updated_at' => now()->subDays(4)],
            ['id' => 3, 'user_id' => $adminUserId, 'action' => 'Ha escanejat el codi 8423102210153 i ha guanyat 100 punts', 'description' => null, 'data' => json_encode(['code' => '8423102210153', 'points' => 100]), 'created_at' => now()->subDays(3), 'updated_at' => now()->subDays(3)],
            ['id' => 4, 'user_id' => $adminUserId, 'action' => 'Ha creat un nou event: Taller de compostatge', 'description' => null, 'data' => json_encode(['type' => 'event', 'name' => 'Taller de compostatge']), 'created_at' => now()->subDays(2), 'updated_at' => now()->subDays(2)],
            ['id' => 5, 'user_id' => $adminUserId, 'action' => 'Ha creat una nova alerta per al punt de recollida ID: 1', 'description' => null, 'data' => json_encode(['type' => 'alert', 'id' => 1]), 'created_at' => now()->subDay(), 'updated_at' => now()->subDay()],
        ]);
    }

    private function seedNavigatorInfos(): void
    {
        DB::table('navigator_infos')->insert([
            ['id' => 1, 'app_code_name' => 'Mozilla', 'app_name' => 'Netscape', 'app_version' => '5.0', 'cookie_enabled' => 1, 'hardware_concurrency' => 8, 'language' => 'ca-ES', 'languages' => json_encode(['ca-ES', 'es-ES']), 'max_touch_points' => 0, 'platform' => 'Win32', 'product' => 'Gecko', 'product_sub' => '20030107', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'vendor' => 'Google Inc.', 'vendor_sub' => '', 'screen_width' => 1920, 'screen_height' => 1080, 'screen_avail_width' => 1920, 'screen_avail_height' => 1040, 'screen_color_depth' => 24, 'screen_pixel_depth' => 24, 'created_at' => now()->subDays(2)],
            ['id' => 2, 'app_code_name' => 'Mozilla', 'app_name' => 'Netscape', 'app_version' => '5.0', 'cookie_enabled' => 1, 'hardware_concurrency' => 4, 'language' => 'es-ES', 'languages' => json_encode(['es-ES', 'ca-ES']), 'max_touch_points' => 5, 'platform' => 'Linux x86_64', 'product' => 'Gecko', 'product_sub' => '20030107', 'user_agent' => 'Mozilla/5.0 (Linux; Android 14)', 'vendor' => 'Google Inc.', 'vendor_sub' => '', 'screen_width' => 390, 'screen_height' => 844, 'screen_avail_width' => 390, 'screen_avail_height' => 800, 'screen_color_depth' => 24, 'screen_pixel_depth' => 24, 'created_at' => now()->subDay()],
        ]);
    }

    private function seedPasswordResetTokens(): void
    {
        DB::table('password_reset_tokens')->insert([
            ['email' => 'marta.costa@reciclat.test', 'token' => Hash::make('reset-token-demo'), 'created_at' => now()->subHours(3)],
        ]);
    }

    private function seedSessions(): void
    {
        DB::table('sessions')->insert([
            ['id' => (string) Str::uuid(), 'user_id' => $this->requireId($this->userIds, 'aina.mila@reciclat.test', 'users.email'), 'ip_address' => '127.0.0.1', 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'payload' => base64_encode(serialize(['locale' => 'ca'])), 'last_activity' => now()->timestamp],
        ]);
    }

    private function requireId(array $map, string $key, string $label): int
    {
        if (! array_key_exists($key, $map)) {
            throw new \RuntimeException("No s'ha trobat la referencia {$label}: {$key}");
        }

        return (int) $map[$key];
    }

    private function assertUserPointsIntegrity(string $email, int $puntsActuals, int $puntsGastats): void
    {
        if ($puntsActuals < 0 || $puntsGastats < 0) {
            throw new \RuntimeException("Valors de punts invalids per a {$email}");
        }
    }
}
