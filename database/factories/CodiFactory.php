<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodiFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->value('id') ?? 1,
            'codi' => $this->faker->unique()->ean13(),
            'punts' => $this->faker->numberBetween(8, 120),
            'data_escaneig' => now()->subDays($this->faker->numberBetween(1, 30)),
        ];
    }
}
