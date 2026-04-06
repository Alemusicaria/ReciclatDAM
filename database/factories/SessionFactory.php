<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SessionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'user_id' => User::query()->inRandomOrder()->value('id') ?? 1,
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => 'Mozilla/5.0 (' . $this->faker->randomElement(['Windows NT 10.0; Win64; x64', 'Linux x86_64']) . ')',
            'payload' => base64_encode(serialize(['locale' => $this->faker->randomElement(['ca', 'es'])])),
            'last_activity' => now()->timestamp,
        ];
    }
}
