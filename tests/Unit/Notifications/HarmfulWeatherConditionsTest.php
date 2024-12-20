<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\HarmfulWeatherConditions;
use PHPUnit\Framework\TestCase;

class HarmfulWeatherConditionsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_notification(): void
    {
        $user = $this->createMock(User::class);

        $notification = new HarmfulWeatherConditions([
            'perception' => 2,
            'uvRays' => 6,
        ]);

        $this->assertSame(['mail', 'vonage'], $notification->via($user));
        $this->assertSame([
            'Potentially harmful weather conditions!',
            'Perception: 2 C',
            'UV rays: 6',
        ], $notification->toMail($user)->introLines);
        $this->assertSame(
            'Potentially harmful weather conditions!Perception: 2 CUV rays: 6',
            $notification->toVonage($user)->content
        );
    }
}
