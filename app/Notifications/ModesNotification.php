<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
class ModesNotification extends Notification implements ShouldBroadcast
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
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Has Left the home')
                    ->action('Notification Action', url('/'))
                    ->line('Please check your home');
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
                'user' => $this->modeData['user'],
                'type' => $this->modeData['type'],
            ]
        ];
    }

    public function toBroadcast(object $notifiable): array
    {
        $userDetails = User::find($this->modeData['user']);
        if (!$userDetails) {
            return [
                'data' => [
                    'notification' => [
                        'title' => $this->modeData['title'],
                        'body' => $this->modeData['body'],
                        'user' => [
                            'name' => 'System',
                            'photo' => 'default-system-image',
                        ],
                        'type' => $this->modeData['type'],
                    ],
                ],
            ];
        }
        else{
            return [
                'data' => [
                    'notification' => [
                        'title' => $this->modeData['title'],
                        'body' => $this->modeData['body'],
                        'user' => [
                            'name' => $userDetails->firstName . ' ' . $userDetails->lastName,
                            'photo' => $userDetails->profile_image,
                        ],
                        'type' => $this->modeData['type'],
                    ],
                ],
            ];
        }
    }
}
