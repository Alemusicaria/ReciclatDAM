<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->schemaStatements() as $statement) {
            DB::unprepared($statement);
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (array_reverse($this->tables()) as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();
    }

    private function schemaStatements(): array
    {
        return $this->filteredStatements(['CREATE TABLE', 'ALTER TABLE']);
    }

    private function filteredStatements(array $allowedPrefixes): array
    {
        $dumpPath = base_path('database-reciclatdam.sql');
        $dump = file_get_contents($dumpPath);
        if ($dump === false) {
            throw new RuntimeException('No s\'ha pogut llegir database-reciclatdam.sql');
        }

        // Remove comment-only lines and MySQL versioned comments so statements
        // actually start with CREATE/ALTER after splitting.
        $dump = preg_replace('/^\s*--.*$/m', '', $dump) ?? $dump;
        $dump = preg_replace('/\/\*![\s\S]*?\*\//', '', $dump) ?? $dump;

        $statements = preg_split('/;\s*(?:\r\n|\r|\n)/', $dump) ?: [];
        $filtered = [];

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if ($statement === '') {
                continue;
            }

            $upper = strtoupper($statement);

            if ($this->shouldSkipStatement($upper)) {
                continue;
            }

            foreach ($allowedPrefixes as $prefix) {
                if (str_starts_with($upper, $prefix)) {
                    $filtered[] = $statement;
                    break;
                }
            }
        }

        return $filtered;
    }

    private function shouldSkipStatement(string $upperStatement): bool
    {
        if (str_starts_with($upperStatement, 'CREATE TABLE `MIGRATIONS`')) {
            return true;
        }

        if (str_starts_with($upperStatement, 'ALTER TABLE `MIGRATIONS`')) {
            return true;
        }

        return false;
    }

    private function tables(): array
    {
        return [
            'activities',
            'alertes_punts_de_recollida',
            'cache',
            'cache_locks',
            'codis',
            'events',
            'event_user',
            'navigator_infos',
            'nivells',
            'opinions',
            'password_reset_tokens',
            'premis',
            'premis_reclamats',
            'productes',
            'punts_de_recollida',
            'rols',
            'sessions',
            'tipus_alertes',
            'tipus_events',
            'users',
        ];
    }
};
