<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Nivell;
use App\Models\Rol;
use App\Models\TipusEvent;
use App\Models\User;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    public function test_calendar_json_returns_event_rows(): void
    {
        $tipus = $this->createTipusEvent();
        $event = Event::query()->create([
            'nom' => 'Event calendari',
            'descripcio' => 'Test JSON',
            'data_inici' => now()->addDay(),
            'data_fi' => now()->addDay()->addHour(),
            'lloc' => 'Sala test',
            'tipus_event_id' => $tipus->id,
            'capacitat' => null,
            'punts_disponibles' => 0,
            'actiu' => true,
            'imatge' => null,
        ]);

        $response = $this->getJson(route('events.getEvents'));

        $response->assertOk();

        $eventRow = collect($response->json())->firstWhere('id', $event->id);
        $this->assertNotNull($eventRow);
        $this->assertNotEmpty($eventRow['start']);
    }

    public function test_event_registration_respects_capacity(): void
    {
        $tipus = $this->createTipusEvent();
        $event = Event::query()->create([
            'nom' => 'Event capacitat 1',
            'descripcio' => 'Test capacity',
            'data_inici' => now()->addDay(),
            'data_fi' => now()->addDay()->addHour(),
            'lloc' => 'Sala test',
            'tipus_event_id' => $tipus->id,
            'capacitat' => 1,
            'punts_disponibles' => 10,
            'actiu' => true,
            'imatge' => null,
        ]);

        $firstUser = $this->createUser('First');
        $secondUser = $this->createUser('Second');

        $this->actingAs($firstUser)
            ->postJson(route('events.register', $event->id))
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->actingAs($secondUser)
            ->postJson(route('events.register', $event->id))
            ->assertOk()
            ->assertJsonPath('full', true);
    }

    private function createTipusEvent(): TipusEvent
    {
        return TipusEvent::query()->firstOrCreate(
            ['id' => 1],
            [
                'nom' => 'General',
                'descripcio' => 'Tipus general',
                'color' => '#3788d8',
            ]
        );
    }

    private function createUser(string $prefix): User
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
            'nom' => $prefix,
            'cognoms' => 'Test',
            'email' => strtolower($prefix) . '.' . uniqid() . '@reciclat.test',
            'password' => bcrypt('password'),
            'rol_id' => $rol->id,
            'nivell_id' => $nivell->id,
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
        ]);
    }
}
