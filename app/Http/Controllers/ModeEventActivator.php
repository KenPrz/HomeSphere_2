<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\Modes\ToggleModeEvent;
use App\Events\DeviceUpdateEvent;
class ModeEventActivator extends Controller
{
    /**
     * Handles the mode activation based on the given mode ID.
     *
     * @param int $mode_id The ID of the mode to be activated.
     * @return void
     */
    public function handleMode($mode_id)
    {
        $getModeParams = DB::table('mode_environments')
            ->where('mode_id', $mode_id)
            ->first();
        if($getModeParams->trigger_sensor == 'temperature') {
            $this->handleTemperature($getModeParams);
        }
        else if($getModeParams->trigger_sensor == 'humidity') {
            $this->handleHumidity($getModeParams);
        }
    }

    /**
     * Handles the temperature data.
     *
     * @param object $data The data object.
     * @return void
     */
    private function handleTemperature($data){
        $getCurrentTemperature = DB::table('temp_sensors')
            ->where('room_id', $data->room_id)
            ->value('temperature');
        $this->mainHandler($data, $getCurrentTemperature);
    }

    /**
     * Handles the humidity data.
     *
     * @param object $data The data object.
     * @return void
     */
    private function handleHumidity($data){
        $getCurrentHumidity = DB::table('humidity_sensors')
            ->where('room_id', $data->room_id)
            ->value('humidity');
        $this->mainHandler($data, $getCurrentHumidity);
    }

    /**
     * Handles the main logic for activating or deactivating a mode based on the given data and current value.
     *
     * @param object $data The data object containing the threshold, value, and mode ID.
     * @param int|float $currentValue The current value to compare against the threshold.
     * @return void
     */
    private function mainHandler($data, $currentValue){
        if($data->threshold == 'above') {
            if($currentValue > $data->value) {
                $this->activateMode($data->mode_id);
            }
            else if($currentValue < $data->value) {
                $this->deactivateMode($data->mode_id);
            }
        }
        else if($data->threshold == 'below') {
            if($currentValue < $data->value) {
                $this->activateMode($data->mode_id);
            }
            else if($currentValue > $data->value) {
                $this->deactivateMode($data->mode_id);
            }
        }
        else if($data->threshold == 'specifically') {
            if($currentValue == $data->value) {
                $this->activateMode($data->mode_id);
            }
            else if($currentValue != $data->value) {
                $this->deactivateMode($data->mode_id);
            }
        }
    }

    /**
     * Activate a mode by setting its 'is_active' flag to true and triggering a ToggleModeEvent.
     *
     * @param int $mode_id The ID of the mode to activate.
     * @return void
     */
    private function activateMode($mode_id){
        $is_mode_active = DB::table('modes')->where('id', $mode_id)->value('is_active');
        if($is_mode_active==false){
            DB::table('modes')->where('id', $mode_id)
                ->update([
                'is_active' => true,
            ]);
            $homeId = DB::table('modes')->where('id', $mode_id)->value('home_id');
            
            event(new ToggleModeEvent($mode_id, true, $homeId));
            
            $data = DB::table('mode_devices')
                ->where('mode_id', $mode_id)
                ->get();
            if (!empty($data) && !empty($data[0]->device_list)) {
                $device_list = json_decode($data[0]->device_list, true);
                // Check if $device_list is not null before iterating
                if (is_array($device_list)) {
                    foreach ($device_list as $device) {
                        $deviceId = $device['device']['device_id'];
                        $isActive = $device['device']['is_active'];
                        $this->deviceHandle($deviceId, $isActive);
                    }
                } else {
                    echo "Invalid or empty device list.\n";
                }
            } else {
                echo "No data or empty device list found.\n";
            }
        }
    }

    /**
     * Deactivates a mode by setting its 'is_active' flag to false in the database.
     * Triggers a ToggleModeEvent to notify listeners about the mode deactivation.
     * Deactivates all devices associated with the mode.
     *
     * @param int $mode_id The ID of the mode to deactivate.
     * @return void
     */
    private function deactivateMode($mode_id)
    {
        $is_mode_active = DB::table('modes')->where('id', $mode_id)->value('is_active');
        if ($is_mode_active == true) {
            DB::table('modes')->where('id', $mode_id)
                ->update([
                    'is_active' => false,
                ]);
            $homeId = DB::table('modes')->where('id', $mode_id)->value('home_id');

            event(new ToggleModeEvent($mode_id, false, $homeId));

            $data = DB::table('mode_devices')
                ->where('mode_id', $mode_id)
                ->get();
            if (!empty($data) && !empty($data[0]->device_list)) {
                $device_list = json_decode($data[0]->device_list, true);
                // Check if $device_list is not null before iterating
                if (is_array($device_list)) {
                    foreach ($device_list as $device) {
                        $deviceId = $device['device']['device_id'];
                        $isActive = !$device['device']['is_active'];
                        $this->deviceHandle($deviceId, $isActive);
                    }
                } else {
                    echo "Invalid or empty device list.\n";
                }
            } else {
                echo "No data or empty device list found.\n";
            }
        }
    }

    /**
     * Handles the activation or deactivation of a device.
     *
     * @param int $device_id The ID of the device.
     * @param bool $is_active The activation status of the device.
     * @return void
     */
    private function deviceHandle($device_id, $is_active){
        $room_id = DB::table('devices')->where('id', $device_id)->value('room_id');
        DB::table("devices")->where("id", $device_id)->update([
            "is_active" => $is_active,
            "updated_at" => now()
        ]);
        $this->fireEvent($room_id,$device_id, $is_active);
    }

    /**
     * Fires a device update event.
     *
     * @param int $room_id The ID of the room.
     * @param int $device_id The ID of the device.
     * @param bool $is_active The activation status of the device.
     * @return void
     */
    private function fireEvent($room_id,$device_id,$is_active){
        event(new DeviceUpdateEvent($room_id, $device_id, $is_active));
    }
}