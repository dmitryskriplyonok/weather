<?php

namespace Tests\Feature\Weather;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_not_logged(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
    }

    public function test_logged(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }
}
