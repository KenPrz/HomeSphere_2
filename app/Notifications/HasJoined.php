<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
class HasJoined extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $hasJoinedData;
    public function __construct($hasJoinedData)
    {
        $this->hasJoinedData = $hasJoinedData;
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
                'title' => $this->hasJoinedData['title'],
                'body' => $this->hasJoinedData['body'],
                'user' => $this->hasJoinedData['user'],
                'type' => $this->hasJoinedData['type'],
            ]
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        $userDetails = User::find($this->hasJoinedData['user']);
        return [
            'data' => [
                'notification' => [
                    'title' => $this->hasJoinedData['title'],
                    'body' => $this->hasJoinedData['body'],
                    'user' => [
                        'name' => $userDetails->firstName . ' ' . $userDetails->lastName,
                        'photo' => $userDetails->profile_image,
                    ],
                    'type' => $this->hasJoinedData['type'],
                ],
            ],
        ];
    }
}
