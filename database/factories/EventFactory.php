<?php

namespace Database\Factories;

use App\Models\TipusEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $tipusEventId = TipusEvent::query()->inRandomOrder()->value('id') ?? 1;
        $startsAt = now()->addDays($this->faker->numberBetween(3, 45));

        return [
            'nom' => $this->faker->words(3, true),
            'descripcio' => $this->faker->sentence(12),
            'data_inici' => $startsAt,
            'data_fi' => (clone $startsAt)->addHours($this->faker->numberBetween(1, 4)),
            'lloc' => $this->faker->city() . ' - ' . $this->faker->streetName(),
            'tipus_event_id' => $tipusEventId,
            'capacitat' => $this->faker->numberBetween(15, 60),
            'punts_disponibles' => $this->faker->numberBetween(20, 100),
            'actiu' => true,
            'imatge' => 'images/events/' . $this->faker->randomElement(['compostatge.jpg', 'neteja.jpg', 'xerrada.jpg', 'campanya.jpg']),
        ];
    }
}
