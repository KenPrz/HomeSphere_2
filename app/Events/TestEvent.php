<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $room_id;
    public $sensor_data;
    public $device_data;
    public function __construct($room_id,$sensor_data, $device_data)
    {
        $this->room_id = $room_id;
        $this->sensor_data = $sensor_data;
        $this->device_data = $device_data;
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
        return 'sensor_update';
    }

    public function broadcastWith(): array
    {
        return [
            'sensor_data' => [
                'room_id' => $this->room_id,
                'temperature' => $this->sensor_data['temperature'],
                'humidity' => $this->sensor_data['humidity'],
            ]
        ];
    }
}
