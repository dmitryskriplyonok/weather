<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class OpenWeatherClient
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('weather.open_weather_api_key');
    }

    public function fetch(array $parameters): array
    {
        $parameters = array_merge([
            'appid' => $this->apiKey,
        ], $parameters);

        try {
            $response = Http::timeout(10)
                ->withQueryParameters($parameters)
                ->get($this->url());

            if ($response->ok()) {
                return json_decode($response->body(), true);
            }
        } catch (ConnectionException $connectionException) {
            Log::error($connectionException->getMessage());
        }

        return [];
    }

    abstract protected function url(): string;
}
