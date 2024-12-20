<?php

namespace Tests\Feature\Schedule;

use App\Models\User;
use App\Notifications\HarmfulWeatherConditions;
use App\Schedule\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Mockery\MockInterface;
use Tests\TestCase;
use App\Services\Weather as WeatherService;

class WeatherTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_are_notifications_sent(): void
    {
        Notification::fake();

        User::factory(2)->create();

        $weatherService = $this->mock(WeatherService::class, function (MockInterface $mock) {
            $mock->shouldReceive('retrievePerceptionAndUVrays')->twice()->andReturn([
                'perception' => 2,
                'uvRays' => 6,
            ]);
        });

        $weather = new Weather();

        $weather($weatherService);

        Notification::assertSentTimes(HarmfulWeatherConditions::class, 2);
    }
}
