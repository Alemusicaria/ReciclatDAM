<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'nom' => $firstName,
            'cognoms' => $lastName,
            'data_naixement' => $this->faker->date('Y-m-d', '2004-12-31'),
            'telefon' => '600' . $this->faker->unique()->numerify('###'),
            'ubicacio' => $this->faker->city(),
            'punts_totals' => 0,
            'punts_actuals' => 0,
            'punts_gastats' => 0,
            'email' => strtolower($firstName . '.' . $lastName) . '@reciclat.test',
            'email_verified_at' => now(),
            'password' => Hash::make((string) env('DEMO_USER_PASSWORD', 'password')),
            'remember_token' => Str::random(10),
            'rol_id' => 2,
            'foto_perfil' => null,
            'nivell_id' => 1,
        ];
    }
}
