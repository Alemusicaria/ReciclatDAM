<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    public function test_user_can_switch_locale_and_persist_it_in_session(): void
    {
        $response = $this->postJson(route('set-locale'), [
            'locale' => 'es',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('locale', 'es');

        $this->assertSame('es', session('locale'));
    }

    public function test_user_cannot_set_unsupported_locale(): void
    {
        $this->postJson(route('set-locale'), [
            'locale' => 'zz',
        ])->assertStatus(422);
    }
}