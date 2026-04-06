<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (app()->runningUnitTests() || app()->environment('testing')) {
            $this->createTestingSchema();
            return;
        }

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

    private function createTestingSchema(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('rols', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('nivells', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->integer('punts_requerits')->default(0);
            $table->text('descripcio')->nullable();
            $table->string('icona')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->string('cognoms');
            $table->date('data_naixement')->nullable();
            $table->string('telefon')->nullable();
            $table->string('ubicacio')->nullable();
            $table->integer('punts_totals')->default(0);
            $table->integer('punts_actuals')->default(0);
            $table->integer('punts_gastats')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('rol_id')->default(2);
            $table->string('foto_perfil')->nullable();
            $table->unsignedBigInteger('nivell_id')->default(1);
            $table->timestamps();
        });

        Schema::create('tipus_events', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->text('descripcio')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->text('descripcio')->nullable();
            $table->dateTime('data_inici')->nullable();
            $table->dateTime('data_fi')->nullable();
            $table->string('lloc')->nullable();
            $table->unsignedBigInteger('tipus_event_id')->nullable();
            $table->integer('capacitat')->nullable();
            $table->integer('punts_disponibles')->default(0);
            $table->boolean('actiu')->default(true);
            $table->string('imatge')->nullable();
            $table->timestamps();
        });

        Schema::create('productes', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->string('categoria')->nullable();
            $table->string('imatge')->nullable();
            $table->timestamps();
        });

        Schema::create('event_user', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('punts')->default(0);
            $table->unsignedBigInteger('producte_id')->nullable();
            $table->timestamps();
        });

        Schema::create('codis', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('codi');
            $table->integer('punts')->default(0);
            $table->dateTime('data_escaneig')->nullable();
            $table->timestamps();
        });

        Schema::create('punts_de_recollida', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->string('ciutat')->nullable();
            $table->string('adreca')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->string('fraccio')->nullable();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });

        Schema::create('tipus_alertes', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('alertes_punts_de_recollida', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('punt_de_recollida_id');
            $table->unsignedBigInteger('tipus_alerta_id');
            $table->text('descripció')->nullable();
            $table->string('imatge')->nullable();
            $table->timestamps();
        });

        Schema::create('premis', function (Blueprint $table): void {
            $table->id();
            $table->string('nom');
            $table->text('descripcio')->nullable();
            $table->integer('punts_requerits')->default(0);
            $table->string('imatge')->nullable();
            $table->timestamps();
        });

        Schema::create('premis_reclamats', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('premi_id');
            $table->integer('punts_gastats')->default(0);
            $table->dateTime('data_reclamacio')->nullable();
            $table->string('estat')->default('pendent');
            $table->string('codi_seguiment')->nullable();
            $table->text('comentaris')->nullable();
            $table->timestamps();
        });

        Schema::create('navigator_infos', function (Blueprint $table): void {
            $table->id();
            $table->string('app_code_name')->nullable();
            $table->string('app_name')->nullable();
            $table->string('app_version')->nullable();
            $table->boolean('cookie_enabled')->default(true);
            $table->integer('hardware_concurrency')->nullable();
            $table->string('language')->nullable();
            $table->text('languages')->nullable();
            $table->integer('max_touch_points')->nullable();
            $table->string('platform')->nullable();
            $table->string('product')->nullable();
            $table->string('product_sub')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('vendor')->nullable();
            $table->string('vendor_sub')->nullable();
            $table->integer('screen_width')->nullable();
            $table->integer('screen_height')->nullable();
            $table->integer('screen_avail_width')->nullable();
            $table->integer('screen_avail_height')->nullable();
            $table->integer('screen_color_depth')->nullable();
            $table->integer('screen_pixel_depth')->nullable();
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('action');
            $table->text('description')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });

        Schema::create('opinions', function (Blueprint $table): void {
            $table->id();
            $table->string('autor');
            $table->text('comentari')->nullable();
            $table->decimal('estrelles', 3, 1)->default(0);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table): void {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table): void {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table): void {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

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
