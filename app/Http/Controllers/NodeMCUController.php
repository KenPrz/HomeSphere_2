<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
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
        

    
        return response()->json(['message' => 'Data received successfully', 'data' => $request->all()], 200);  
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

        return Validator::make($request->all(), $rules);
    }

    
    private function updateRoomData($room_id, $sensorData)
    {
        DB::table('rooms')->where('id', $room_id)->update([
            'temperature' => $sensorData['temperature'],
            'humidity' => $sensorData['humidity'],
        ]);
    }
}
