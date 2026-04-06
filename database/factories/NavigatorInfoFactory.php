<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NavigatorInfoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'app_code_name' => 'Mozilla',
            'app_name' => 'Netscape',
            'app_version' => '5.0',
            'cookie_enabled' => true,
            'hardware_concurrency' => $this->faker->numberBetween(2, 16),
            'language' => $this->faker->randomElement(['ca-ES', 'es-ES']),
            'languages' => json_encode(['ca-ES', 'es-ES']),
            'max_touch_points' => $this->faker->numberBetween(0, 10),
            'platform' => $this->faker->randomElement(['Win32', 'Linux x86_64', 'MacIntel']),
            'product' => 'Gecko',
            'product_sub' => '20030107',
            'user_agent' => 'Mozilla/5.0 (' . $this->faker->randomElement(['Windows NT 10.0; Win64; x64', 'Linux; Android 14', 'Macintosh; Intel Mac OS X 14_0']) . ')',
            'vendor' => 'Google Inc.',
            'vendor_sub' => '',
            'screen_width' => 1920,
            'screen_height' => 1080,
            'screen_avail_width' => 1920,
            'screen_avail_height' => 1040,
            'screen_color_depth' => 24,
            'screen_pixel_depth' => 24,
        ];
    }
}
