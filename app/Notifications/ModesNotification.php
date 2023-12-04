<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModesNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $modeData;

    public function __construct($modeData)
    {
        $this->modeData = $modeData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'notification' =>  [
                'title' => $this->modeData['title'],
                'body' => $this->modeData['body'],
                'user_name' => $this->modeData['user_name'],
                'icon' => $this->modeData['icon'],
            ]
        ];
    }
}
