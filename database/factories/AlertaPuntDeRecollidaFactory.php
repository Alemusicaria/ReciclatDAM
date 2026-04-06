<?php

namespace Database\Factories;

use App\Models\PuntDeRecollida;
use App\Models\TipusAlerta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertaPuntDeRecollidaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? 1,
            'punt_de_recollida_id' => PuntDeRecollida::query()->inRandomOrder()->value('id') ?? 1,
            'tipus_alerta_id' => TipusAlerta::query()->inRandomOrder()->value('id') ?? 1,
            'descripció' => $this->faker->sentence(8),
            'imatge' => 'images/alertes/' . $this->faker->randomElement(['ple.jpg', 'trencat.jpg', 'acces.jpg']),
        ];
    }
}
