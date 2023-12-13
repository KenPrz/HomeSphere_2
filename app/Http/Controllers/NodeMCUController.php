<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Humidity_sensor;
use App\Models\Temp_sensor;
use App\Models\Gas_sensor;
use App\Models\Motion_sensor;
use App\Events\MotionDetectedEvent;
use App\Events\DeviceIsOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class NodeMCUController extends Controller
{
    /**
     * Receive data from NodeMCU and update room data accordingly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function receiveData(Request $request)
    {
        $validationResult = $this->validateData($request);

        if ($validationResult->fails()) {
            return response()->json(['errors' => $validationResult->errors()], 422);
        }

        $home_id = DB::table('home_api_keys')
            ->whereRaw('BINARY api_key = ?', [$request->key])
            ->value('home_id');

        if (!$home_id) {
            return response()->json(['errors' => ['key' => ['Invalid API key']]], 422);
        }

        $room_id = DB::table('rooms')
            ->where('home_id', $home_id)
            ->where('room_name', $request->room_name)
            ->value('id');

        if (!$room_id) {
            return response()->json(['errors' => ['room_name' => ['Invalid room name']]], 422);
        }
        $sensorData = $request->sensor_data;
        $this->updateSensorData($room_id, $sensorData,$home_id);

        $device_data = $request->all();
        if (isset($device_data['devices'])) {
            $this->deviceUpdate($device_data, $room_id);
            // Final Reply to the node.//
            return $this->responseBuilder($room_id);
        } else {
            return response()->json(['message' => 'Room Data Updated'], 200);
        }
        
    }

    /**
     * Validates the data from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateData(Request $request)
    {
        $rules = [
            'key' => ['required', 'string', 'size:64'],
            'room_name' => ['required', 'string', 'max:255'],
            'sensor_data.temperature' => ['numeric'],
            'sensor_data.humidity' => ['numeric'],
            'sensor_data.motion_sensor' => ['boolean'],
            'sensor_data.gas_levels' => ['numeric'],
            'devices.lights.*.name' => 'required|string|distinct:strict',
            'devices.lights.*.is_active' => 'required|boolean',
            'devices.plugs.*.name' => 'required|string|distinct:strict',
            'devices.plugs.*.is_active' => 'required|boolean',
        ];
        return Validator::make($request->all(), $rules);
    }

    
    /**
     * Update the temperature and humidity data for a given room.
     *
     * @param int $room_id The ID of the room to update.
     * @param array $sensorData An array containing the temperature and humidity data.
     * @return void
     */
    private function updateSensorData($room_id, $sensorData, $home_id)
    {
        if (isset($sensorData['temperature'])) {
            Temp_sensor::updateOrInsert(
                ['room_id' => $room_id],
                ['temperature' => $sensorData['temperature']]
            );
        }
    
        if (isset($sensorData['humidity'])) {
            Humidity_sensor::updateOrInsert(
                ['room_id' => $room_id],
                ['humidity' => $sensorData['humidity']]
            );
        }
        if (isset($sensorData['gas_levels'])) {
            Gas_sensor::updateOrInsert(
                ['room_id' => $room_id],
                ['gas_levels' => $sensorData['gas_levels']]
            );
        }
        if(isset($sensorData['motion_sensor'])) {
            $data = Motion_sensor::where('room_id', $room_id)->pluck('is_active')->toArray();
            if($data[0] == (1||true) && $sensorData['motion_sensor'] == true)
            { 
                event(new MotionDetectedEvent($home_id, $room_id));
            }
        }
    }
/**
 * Update or insert devices for a given room.
 *
 * @param array $data The data containing the devices to update or insert.
 * @param int $room_id The ID of the room to update or insert the devices for.
 * @return void
 */
private function deviceUpdate($data, $room_id)
{
    $lights = $data['devices']['lights'];
    $plugs = $data['devices']['plugs'];

    // Update or insert lights
    foreach ($lights as $lightData) {
        $this->updateOrInsertDevice($lightData, $room_id, 'light');
    }

    // Update or insert plugs
    foreach ($plugs as $plugData) {
        $this->updateOrInsertDevice($plugData, $room_id, 'plug');
    }
}

/**
 * Update or insert a device into the database.
 *
 * @param array $deviceData The data of the device to be updated or inserted.
 * @param int $room_id The ID of the room where the device is located.
 * @param string $type The type of the device.
 * @return void
 */
private function updateOrInsertDevice($deviceData, $room_id, $type)
{
    $deviceName = $deviceData['name'];

    $device = Device::where('room_id', $room_id)
        ->where('device_type', $type)
        ->where('device_name', $deviceName)
        ->first();
    if ($device) {
        $last_access = Carbon::parse($device->last_access);
        if ($last_access->diffInMinutes(Carbon::now()) > 1){
            event(new DeviceIsOnline($room_id,$device->id,true));
        }
        $device->last_access = now();
        $device->save();
    }else{
        Device::create([
            'room_id' => $room_id,
            'device_type' => $type,
            'device_name' => $deviceName,
            'custom_name' => null,
            'last_access' => now(),
            'is_active' => $deviceData['is_active']
        ]);
    }
}
    /**
     * Builds a JSON response containing the list of lights and plugs for a given room.
     *
     * @param int $room_id The ID of the room to retrieve the devices from.
     * @return // JSON response containing the list of lights and plugs.
     */
    private function responseBuilder($room_id)
    {
        $lights = DB::table('devices')
            ->where('room_id', $room_id)
            ->where('device_type', 'light')
            ->get([
                "device_name",
                "device_type" ,
                "is_active"
            ]);

        $plugs = DB::table('devices')
            ->where('room_id', $room_id)
            ->where('device_type', 'plug')
            ->get([
                "device_name",
                "device_type" ,
                "is_active"
            ]);
        if(($plugs && $lights)){

            return response()->json([
                'lights' => $lights,
                'plugs' => $plugs
            ], 200);
        }
        else{
            return response()->json([
                'error' => 'internal server error'
            ],500);
        }
        
    }
    public function test(Request $request){
        if($request){
            return response()->json([
                'message' => 'success'
            ],200);
        }
        else{
            return response()->json([
                'message' => 'failed'
            ],500);
        }
    }
}
