<?php

namespace Tests\Feature\Services\OpenWeatherClient;

use App\Services\OpenWeatherClient\Data;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DataTest extends TestCase
{
    public function test_fetch(): void
    {
        $data = [
            'fells_like' => 5.5,
            'uvi' => 0.2,
        ];

        Http::fake([
            'https://api.openweathermap.org/data/3.0/onecall?appid=3ec9b8d03d8fd37ffdaceaa1b30bf581&units=metric&lat=51.5073219&lon=-0.1276474' => Http::response($data)
        ]);

        $dataClient = new Data();

        $response = $dataClient->fetch([
            'units' => 'metric',
            'lat' => 51.5073219,
            'lon' => -0.1276474,
        ]);

        $this->assertSame($data, $response);
    }
}
