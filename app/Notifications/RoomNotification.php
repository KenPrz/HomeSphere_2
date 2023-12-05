<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
class RoomNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $roomData;
    public function __construct($roomData)
    {
        $this->roomData = $roomData;
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
                'title' => $this->roomData['title'],
                'body' => $this->roomData['body'],
                'user' => $this->roomData['user'],
                'type' => $this->roomData['type'],
            ]
        ];
    }


    /**
     * Get the array representation of the notification for broadcasting.
     *
     * @param  object  $notifiable
     * @return array<string, mixed>
     */
    public function toBroadcast(object $notifiable): array
    {
        $userDetails = User::find($this->roomData['user']);
        return [
            'data' => [
                'notification' => [
                    'title' => $this->roomData['title'],
                    'body' => $this->roomData['body'],
                    'user' => [
                        'name' => $userDetails->firstName . ' ' . $userDetails->lastName,
                        'photo' => $userDetails->profile_image,
                    ],
                    'type' => $this->roomData['type'],
                ],
            ],
        ];
    }

}
