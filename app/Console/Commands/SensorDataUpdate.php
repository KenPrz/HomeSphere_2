<?php

namespace App\Console\Commands;
use App\Events\SensorUpdateEvent;
use Illuminate\Console\Command;
use App\Models\Room;
class SensorDataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensor:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update sensor data every 60 seconds.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Room::all()->each(function ($room) {
            event(new SensorUpdateEvent($room->id));
        });
    }
}
