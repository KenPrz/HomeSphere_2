<?php

namespace App\Console\Commands;
use App\Models\Device;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Events\DeviceIsOnline;
class DeviceActivityChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for device activity and update device status accordingly.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $devices = Device::all();
        foreach ($devices as $device) {
            $last_access = Carbon::parse($device->last_access);
            if ($last_access->diffInMinutes(Carbon::now()) > 2) {
                event(new DeviceIsOnline($device->room_id,$device->id,false));
            }
            //  else {
            //     event(new DeviceIsOnline($device->room_id,$device->id,true));
            // }
        }
    }
}
