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
    public $sensorData;
    public $home_id;

    public function __construct($sensorData, $home_id)
    {
        $this->sensorData = $sensorData;
        $this->home_id = $home_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('home.'.$this->home_id),
        ];
    }

    public function broadcastAs(){
        return 'sensor_update';
    }

    public function broadcastWith(): array
    {
        return [
            'sensor_data' => [
                'temperature' => $this->sensorData['temperature'],
                'humidity' => $this->sensorData['humidity'],
            ]
        ];
    }
}
