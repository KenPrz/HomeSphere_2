<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
class WasPromoted extends Notification
{
    use Queueable;

    public $wasPromotedData;
    /**
     * Create a new notification instance.
     */
    public function __construct($wasPromotedData)
    {
        $this->wasPromotedData = $wasPromotedData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
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
                'title' => $this->wasPromotedData['title'],
                'body' => $this->wasPromotedData['body'],
                'user' => $this->wasPromotedData['user'],
                'type' => $this->wasPromotedData['type'],
            ]
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        $userDetails = User::find($this->wasPromotedData['user']);
        return [
            'data' => [
                'notification' => [
                    'title' => $this->wasPromotedData['title'],
                    'body' => $this->wasPromotedData['body'],
                    'user' => [
                        'name' => $userDetails->firstName . ' ' . $userDetails->lastName,
                        'photo' => $userDetails->profile_image,
                    ],
                    'type' => $this->wasPromotedData['type'],
                ],
            ],
        ];
    }
}
