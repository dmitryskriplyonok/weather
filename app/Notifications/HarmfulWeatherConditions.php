<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class HarmfulWeatherConditions extends Notification
{
    use Queueable;

    private float $perception;
    private float $uvRays;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $weatherConditions)
    {
        $this->perception = $weatherConditions['perception'] ?? 0;
        $this->uvRays = $weatherConditions['uvRays'] ?? 0;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'vonage'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Potentially harmful weather conditions!')
                    ->line('Perception: ' . $this->perception . ' C')
                    ->line('UV rays: ' . $this->uvRays);
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     */
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Potentially harmful weather conditions!'
                . 'Perception: ' . $this->perception . ' C'
                . 'UV rays: ' . $this->uvRays
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
