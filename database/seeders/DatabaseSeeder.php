<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (['activities', 'alertes_punts_de_recollida', 'codis', 'event_user', 'events', 'navigator_infos', 'nivells', 'opinions', 'password_reset_tokens', 'premis_reclamats', 'premis', 'productes', 'punts_de_recollida', 'rols', 'sessions', 'tipus_alertes', 'tipus_events', 'users'] as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        $seedMode = strtolower((string) env('SEED_MODE', 'snapshot'));

        $seeders = [ProtectedTablesSeeder::class];

        if ($seedMode === 'demo') {
            $seeders[] = DemoFactoriesSeeder::class;
        } elseif ($seedMode === 'snapshot') {
            $seeders[] = DemoDataSeeder::class;
        } else {
            throw new \RuntimeException("SEED_MODE invalid: {$seedMode}. Usa snapshot o demo.");
        }

        $this->call($seeders);

        Schema::enableForeignKeyConstraints();
    }
}
