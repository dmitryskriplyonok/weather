<?php

namespace Tests\Feature\Services\OpenWeatherClient;

use App\Services\OpenWeatherClient\Geo;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeoTest extends TestCase
{
    public function test_fetch(): void
    {
        $data = [
            'lat' => 51.5073219,
            'lon' => -0.1276474,
        ];

        Http::fake([
            'https://api.openweathermap.org/geo/1.0/direct?appid=3ec9b8d03d8fd37ffdaceaa1b30bf581&q=London' => Http::response($data)
        ]);

        $geoClient = new Geo();

        $response = $geoClient->fetch(['q' => 'London']);

        $this->assertSame($data, $response);
    }
}
