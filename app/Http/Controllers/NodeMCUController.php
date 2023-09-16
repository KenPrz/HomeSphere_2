<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NodeMCUController extends Controller
{
    public function receiveData(Request $request)
    {
        $validationResult = $this->validateData($request);

        if ($validationResult->fails()) {
            return response()->json(['errors' => $validationResult->errors()], 422);
        }

        $home_id = DB::table('home_api_keys')->where('api_key', $request->key)->value('home_id');

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
        $this->updateRoomData($room_id, $sensorData);
        $myData = $request->all();

        $this->deviceUpdate($myData, $room_id);
        //Final Reply to the node.
        return $this->responseBuilder($room_id);
    }

    private function validateData(Request $request)
    {
        $rules = [
            'key' => ['required', 'string', 'size:64'],
            'room_name' => ['required', 'string', 'max:255'],
            'sensor_data.temperature' => ['numeric'],
            'sensor_data.humidity' => ['numeric'],
            'devices.lights.*.name' => 'required|string',
            'devices.lights.*.is_active' => 'required|boolean',
            'devices.plugs.*.name' => 'required|string',
            'devices.plugs.*.is_active' => 'required|boolean',
        ];
            //TODO prevent duplication in request
        return Validator::make($request->all(), $rules);
    }

    
    private function updateRoomData($room_id, $sensorData)
    {
        DB::table('rooms')->where('id', $room_id)->update([
            'temperature' => $sensorData['temperature'],
            'humidity' => $sensorData['humidity'],
        ]);
    }

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

private function updateOrInsertDevice($deviceData, $room_id, $type)
{
    $deviceName = $deviceData['name'];

    $device = Device::where('room_id', $room_id)
        ->where('device_type', $type)
        ->where('device_name', $deviceName)
        ->first();

    if ($device) {
        $device->update([
            'is_active' => $deviceData['is_active'],
            // Add other properties to update here if necessary
        ]);
    } else {
        Device::create([
            'room_id' => $room_id,
            'device_type' => $type,
            'device_name' => $deviceName,
            'is_active' => $deviceData['is_active'],
            // Add other properties to insert here if necessary
        ]);
    }
}
    //Todo Create a response builder for the API
    private function responseBuilder($room_id)
    {
        $data = DB::table('devices')->where('room_id', $room_id)
            ->get([
                "device_name",
                "device_type",
                "is_active"
            ]);
    
        $lights = $data->filter(function ($device) {
            return $device->device_type === 'light';
        });
    
        $plugs = $data->filter(function ($device) {
            return $device->device_type === 'plug';
        });
    
        return response()->json([
            'message' => 'reply',
            'lights' => $lights,
            'plugs' => $plugs
        ], 200);
    }
    
}
