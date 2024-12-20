<?php

namespace App\Schedule;

use App\Models\User;
use App\Notifications\HarmfulWeatherConditions;
use App\Services\Weather as WeatherService;

class Weather
{
    public function __invoke(WeatherService $weatherService): void
    {
        /** @var User[] $users */
        $users = User::with('cities')->get();

        foreach ($users as $user) {
            $conditions = $weatherService->retrievePerceptionAndUVrays($user);

            if ($conditions['perception'] < 5 || $conditions['uvRays'] > 5) {
                $user->notify(new HarmfulWeatherConditions($conditions));
            }
        }
    }
}
