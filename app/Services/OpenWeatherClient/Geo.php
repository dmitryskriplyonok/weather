<?php

namespace App\Services\OpenWeatherClient;

use App\Services\OpenWeatherClient;

class Geo extends OpenWeatherClient
{

    protected function url(): string
    {
        return 'https://api.openweathermap.org/geo/1.0/direct';
    }
}
