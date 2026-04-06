<?php

namespace Database\Factories;

use App\Models\Premi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PremiReclamatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? 1,
            'premi_id' => Premi::query()->inRandomOrder()->value('id') ?? 11,
            'punts_gastats' => $this->faker->numberBetween(20, 300),
            'data_reclamacio' => now()->subDays($this->faker->numberBetween(3, 35)),
            'estat' => $this->faker->randomElement(['pendent', 'procesant', 'entregat', 'cancelat']),
            'codi_seguiment' => 'TRK-' . strtoupper($this->faker->bothify('??##??##')),
            'comentaris' => $this->faker->sentence(10),
        ];
    }
}
