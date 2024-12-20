<?php

namespace App\Services;

use App\Models\User;
use App\Services\OpenWeatherClient\Data;
use App\Services\OpenWeatherClient\Geo;

class Weather
{
    public function __construct(
        private readonly Geo $openWeatherGeoClient,
        private readonly Data $openWeatherDataClient
    ) {
    }

    public function retrievePerceptionAndUVrays(User $user): array
    {
        $city = $user->cities->first();
        if (!$city) {
            return [
                'perception' => 0,
                'uvRays' => 0,
            ];
        }

        if (!$city->lat || !$city->lon) {
            $cityGeoLocation = $this->retrieveCityGeoLocation($city->name);
            if (empty($cityGeoLocation)) {
                return [
                    'perception' => 0,
                    'uvRays' => 0,
                ];
            }

            $city->lat = $cityGeoLocation['lat'];
            $city->lon = $cityGeoLocation['lon'];
            $city->save();
        } else {
            $cityGeoLocation = [
                'lat' => $city->lat,
                'lon' => $city->lon,
            ];
        }

        $parameters = array_merge([
            'units' => 'metric',
        ], $cityGeoLocation);

        $data = $this->openWeatherDataClient->fetch($parameters);

        return [
            'perception' => $data['current']['feels_like'] ?? 0,
            'uvRays' => $data['current']['uvi'] ?? 0,
        ];
    }

    private function retrieveCityGeoLocation(string $city): array
    {
        $data = $this->openWeatherGeoClient->fetch(['q' => $city]);
        if (empty($data)) {
            return [];
        }
        $data = reset($data);

        return [
            'lat' => $data['lat'],
            'lon' => $data['lon'],
        ];
    }
}
