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

        $data = $validationResult->validated();

        $room = $this->findRoomByName($data['room_name']);
        $apiKey = $this->findApiKeyByKey($data['key']);

        if ($apiKey && $room) {
            $this->updateRoomData($room, $data['sensor_data']);
            return response()->json(['message' => 'Data received successfully', 'data' => $data], 200);
        } else {
            return response()->json(['message' => 'BAD API'], 401);
        }
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

    private function findRoomByName($roomName)
    {
        return DB::table('rooms')->where('room_name', $roomName)->first();
    }

    private function findApiKeyByKey($apiKey)
    {
        return DB::table('home_api_keys')->where('api_key', $apiKey)->first();
    }

    private function updateRoomData($room, $sensorData)
    {
        DB::table('rooms')->where('room_name', $room->room_name)->update([
            'temperature' => $sensorData['temperature'],
            'humidity' => $sensorData['humidity'],
            'updated_at' => now(),
        ]);
    }
}
