<?php

namespace Tests\Feature\Services;

use App\Models\City;
use App\Models\User;
use App\Services\OpenWeatherClient\Data;
use App\Services\OpenWeatherClient\Geo;
use App\Services\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class WeatherTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_retrieve_perception_and_uv_rays(): void
    {
        $user = User::factory()
            ->hasAttached(City::factory())
            ->create();

        $geoClient = $this->mock(Geo::class);
        $dataClient = $this->mock(Data::class, function (MockInterface $mock) {
            $mock->shouldReceive('fetch')->once()->andReturn([
                'current' => [
                    'feels_like' => 4.4,
                    'uvi' => 1.9,
                ],
            ]);
        });

        $weather = new Weather($geoClient, $dataClient);

        $this->assertSame([
            'perception' => 4.4,
            'uvRays' => 1.9,
        ], $weather->retrievePerceptionAndUVrays($user));
    }
}
