<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        $roomIds = 1;

        $devicesData = [];

        for ($i = 1; $i <= 50; $i++) {
            $room_id = 1;

            $devicesData[] = [
                'room_id' => $room_id,
                'device_name' => 'Device ' . $i,
                'device_type' => ($i % 2 == 0) ? 'plug' : 'light',
                'is_active' => ($i % 2 == 0) ? true : false,
            ];
        }

        // Insert the data into the 'devices' table
        DB::table('devices')->insert($devicesData);
    }
}
