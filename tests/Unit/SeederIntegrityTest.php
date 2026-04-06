<?php

namespace Tests\Unit;

use Database\Seeders\DemoDataSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SeederIntegrityTest extends TestCase
{
    public function test_protected_sql_contains_only_the_protected_tables(): void
    {
        $sql = file_get_contents(base_path('database/seeders/sql/protected_tables.sql'));

        $this->assertNotFalse($sql);
        $sql = (string) $sql;

        foreach (['rols', 'nivells', 'opinions', 'premis', 'productes', 'punts_de_recollida', 'tipus_alertes', 'tipus_events'] as $table) {
            $this->assertStringContainsString("INSERT INTO `{$table}`", $sql);
        }

        foreach (['users', 'events', 'event_user', 'codis', 'alertes_punts_de_recollida', 'premis_reclamats', 'activities', 'navigator_infos', 'password_reset_tokens', 'sessions'] as $table) {
            $this->assertStringNotContainsString("INSERT INTO `{$table}`", $sql);
        }
    }

    public function test_demo_data_seeder_uses_stable_refs_and_coherent_points(): void
    {
        $connection = new FakeArrayConnection($this->protectedFixture());
        DB::swap($connection);

        Schema::shouldReceive('disableForeignKeyConstraints')->andReturnNull();
        Schema::shouldReceive('enableForeignKeyConstraints')->andReturnNull();

        (new DemoDataSeeder())->run();

        $users = $connection->tableRows('users');
        $this->assertCount(6, $users);

        foreach ($users as $user) {
            $this->assertStringEndsWith('.test', $user['email']);
            $this->assertSame($user['punts_actuals'] + $user['punts_gastats'], $user['punts_totals']);
        }

        $this->assertCount(4, $connection->tableRows('events'));
        $this->assertCount(4, $connection->tableRows('event_user'));
        $this->assertCount(5, $connection->tableRows('codis'));
        $this->assertCount(3, $connection->tableRows('alertes_punts_de_recollida'));
        $this->assertCount(3, $connection->tableRows('premis_reclamats'));

        foreach ($connection->tableRows('event_user') as $pivot) {
            $this->assertTrue($connection->exists('events', 'id', $pivot['event_id']));
            $this->assertTrue($connection->exists('users', 'id', $pivot['user_id']));
            $this->assertTrue($connection->exists('productes', 'id', $pivot['producte_id']));
        }

        foreach ($connection->tableRows('alertes_punts_de_recollida') as $alerta) {
            $this->assertTrue($connection->exists('users', 'id', $alerta['user_id']));
            $this->assertTrue($connection->exists('punts_de_recollida', 'id', $alerta['punt_de_recollida_id']));
            $this->assertTrue($connection->exists('tipus_alertes', 'id', $alerta['tipus_alerta_id']));
        }

        foreach ($connection->tableRows('premis_reclamats') as $reclamat) {
            $this->assertContains($reclamat['estat'], ['pendent', 'procesant', 'entregat', 'cancelat']);
            $this->assertTrue($connection->exists('users', 'id', $reclamat['user_id']));
            $this->assertTrue($connection->exists('premis', 'id', $reclamat['premi_id']));
        }
    }

    private function protectedFixture(): array
    {
        return [
            'rols' => [
                ['id' => 1, 'nom' => 'Admin'],
                ['id' => 2, 'nom' => 'User'],
            ],
            'nivells' => [
                ['id' => 1, 'nom' => 'Principiant', 'punts_requerits' => 0, 'descripcio' => 'Nivell inicial per a tots els usuaris', 'icona' => 'fas fa-seedling', 'color' => '#4CAF50', 'created_at' => '2025-05-15 09:37:29', 'updated_at' => '2025-05-15 09:37:29'],
                ['id' => 2, 'nom' => 'Aprenent', 'punts_requerits' => 100, 'descripcio' => 'Has començat el teu camí cap a un món més sostenible', 'icona' => 'fas fa-leaf', 'color' => '#8BC34A', 'created_at' => '2025-05-15 09:37:29', 'updated_at' => '2025-05-15 09:37:29'],
                ['id' => 3, 'nom' => 'Reciclador', 'punts_requerits' => 500, 'descripcio' => 'Estàs fent una diferència real en el medi ambient', 'icona' => 'fas fa-recycle', 'color' => '#00BCD4', 'created_at' => '2025-05-15 09:37:29', 'updated_at' => '2025-05-15 09:37:29'],
                ['id' => 4, 'nom' => 'Expert', 'punts_requerits' => 1000, 'descripcio' => 'La teva contribució és molt valuosa per al planeta', 'icona' => 'fas fa-award', 'color' => '#3F51B5', 'created_at' => '2025-05-15 09:37:29', 'updated_at' => '2025-05-15 09:37:29'],
                ['id' => 5, 'nom' => 'Mestre', 'punts_requerits' => 2500, 'descripcio' => 'Ets un exemple a seguir en sostenibilitat', 'icona' => 'fas fa-crown', 'color' => '#FFC107', 'created_at' => '2025-05-15 09:37:29', 'updated_at' => '2025-05-15 09:37:29'],
                ['id' => 6, 'nom' => 'Llegenda', 'punts_requerits' => 5000, 'descripcio' => 'Has assolit el màxim nivell de conscienciació ambiental', 'icona' => 'fas fa-star', 'color' => '#FF5722', 'created_at' => '2025-05-15 09:37:29', 'updated_at' => '2025-05-15 09:37:29'],
            ],
            'opinions' => [
                ['id' => 1, 'autor' => 'Maria P.', 'comentari' => 'M\'encanta aquest servei, és increïble!', 'estrelles' => 4.8, 'created_at' => '2025-04-16 10:40:20', 'updated_at' => '2025-04-16 10:40:20'],
                ['id' => 2, 'autor' => 'Joan G.', 'comentari' => 'Un servei excel·lent, molt recomanable.', 'estrelles' => 4.5, 'created_at' => '2025-04-16 10:40:20', 'updated_at' => '2025-04-16 10:40:20'],
                ['id' => 3, 'autor' => 'Anna R.', 'comentari' => 'La millor experiència que he tingut mai!', 'estrelles' => 5.0, 'created_at' => '2025-04-16 10:40:20', 'updated_at' => '2025-04-16 10:40:20'],
            ],
            'premis' => [
                ['id' => 11, 'nom' => 'Tablet', 'descripcio' => 'Tablet nova', 'punts_requerits' => 3000, 'imatge' => 'images/Premis/tablet.jpg'],
                ['id' => 12, 'nom' => 'Moto elèctrica', 'descripcio' => 'Moto elèctrica marca bmw', 'punts_requerits' => 10000, 'imatge' => 'images/Premis/moto_elèctrica.png'],
                ['id' => 13, 'nom' => 'Patinet elèctric', 'descripcio' => 'marca tesla', 'punts_requerits' => 2000, 'imatge' => 'images/Premis/patinet_elèctric.jpg'],
                ['id' => 14, 'nom' => 'bicicleta', 'descripcio' => 'bicileta nova per estreanr', 'punts_requerits' => 40000, 'imatge' => 'images/Premis/bicicleta.jpg'],
                ['id' => 15, 'nom' => 'motxilla', 'descripcio' => 'motxillal per a sortir exterior', 'punts_requerits' => 200, 'imatge' => 'images/Premis/motxilla.jpg'],
                ['id' => 16, 'nom' => 'provaº', 'descripcio' => 'dsfds', 'punts_requerits' => 23, 'imatge' => 'images/Premis/provaº.jpg'],
                ['id' => 17, 'nom' => 'holas', 'descripcio' => 'shdfhds', 'punts_requerits' => 23, 'imatge' => 'images/Premis/holas.JPG'],
            ],
            'productes' => [
                ['id' => 1, 'nom' => 'Bolígraf'],
                ['id' => 2, 'nom' => 'Càpsules de cafè'],
                ['id' => 3, 'nom' => 'Cassola'],
                ['id' => 4, 'nom' => 'CD/DVD'],
            ],
            'punts_de_recollida' => [
                ['id' => 1, 'nom' => 'Punt Central'],
                ['id' => 2, 'nom' => 'Punt Nord'],
                ['id' => 3, 'nom' => 'Punt Sud'],
                ['id' => 4, 'nom' => 'Punt Est'],
                ['id' => 5, 'nom' => 'Punt Oest'],
            ],
            'tipus_alertes' => [
                ['id' => 1, 'nom' => 'Capacitat'],
                ['id' => 2, 'nom' => 'Desperfectes'],
                ['id' => 3, 'nom' => 'Altres'],
            ],
            'tipus_events' => [
                ['id' => 1, 'nom' => 'Recollida Especial', 'descripcio' => 'Recollida puntual de residus especials com electrodomèstics.', 'color' => '#FF5733'],
                ['id' => 2, 'nom' => 'Tallers Educatius', 'descripcio' => 'Tallers de sensibilització mediambiental.', 'color' => '#33C1FF'],
                ['id' => 3, 'nom' => 'Campanya Informativa', 'descripcio' => 'Campanya per informar sobre el reciclatge correcte.', 'color' => '#75FF33'],
            ],
        ];
    }
}

class FakeArrayConnection
{
    public function __construct(private array $data = [])
    {
    }

    public function table(string $table): FakeArrayTable
    {
        if (! array_key_exists($table, $this->data)) {
            $this->data[$table] = [];
        }

        return new FakeArrayTable($this->data, $table);
    }

    public function connection(?string $name = null): self
    {
        return $this;
    }

    public function getSchemaBuilder(): FakeSchemaBuilder
    {
        return new FakeSchemaBuilder();
    }

    public function unprepared(string $sql): void
    {
        // The protected tables SQL is tested separately; for the demo seeder the fake connection only needs inserts.
    }

    public function tableRows(string $table): array
    {
        return $this->data[$table] ?? [];
    }

    public function exists(string $table, string $column, mixed $value): bool
    {
        foreach ($this->tableRows($table) as $row) {
            if (($row[$column] ?? null) === $value) {
                return true;
            }
        }

        return false;
    }
}

class FakeArrayTable
{
    public function __construct(private array &$data, private string $table)
    {
    }

    public function truncate(): void
    {
        $this->data[$this->table] = [];
    }

    public function insert(array $rows): void
    {
        foreach ($rows as $row) {
            $this->data[$this->table][] = $row;
        }
    }

    public function pluck(string $value, ?string $key = null): \Illuminate\Support\Collection
    {
        return collect($this->data[$this->table] ?? [])->pluck($value, $key);
    }
}

class FakeSchemaBuilder
{
    public function disableForeignKeyConstraints(): void
    {
    }

    public function enableForeignKeyConstraints(): void
    {
    }
}
