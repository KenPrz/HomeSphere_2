<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeviceIsOnline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $device_id;
    public $room_id;
    public $is_online;
    /**
     * Create a new event instance.
     */
    public function __construct($room_id,$device_id,$is_online)
    {
        $this->room_id = $room_id;
        $this->device_id = $device_id;
        $this->is_online = $is_online;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('room.'.$this->room_id),
        ];
    }

    public function broadcastAs(){
        return 'device_online';
    }

    public function broadcastWith(): array
    {
        return [
            'device_data' => [
                'device_id' => $this->device_id,
                'is_online' => $this->is_online,
            ]
        ];
    }
}
