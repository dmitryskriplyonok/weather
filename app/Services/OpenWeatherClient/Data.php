<?php

namespace App\Services\OpenWeatherClient;

use App\Services\OpenWeatherClient;

class Data extends OpenWeatherClient
{

    protected function url(): string
    {
        return 'https://api.openweathermap.org/data/3.0/onecall';
    }
}
