<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProtectedTablesSeeder extends Seeder
{
    public function run(): void
    {
        $sqlPath = base_path('database/seeders/sql/protected_tables.sql');
        $sql = file_get_contents($sqlPath);

        if ($sql === false) {
            throw new \RuntimeException("No s'ha pogut llegir el fitxer SQL protegit.");
        }

        DB::unprepared($sql);
    }
}
