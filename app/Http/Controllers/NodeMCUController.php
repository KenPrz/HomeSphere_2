<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class NodeMCUController extends Controller
{
    public function receiveData(Request $request)
    {
        // Define the validation rules
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
        
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed, return validation error messages
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // If validation succeeds, process the incoming data
        $data = $validator->validated();
        
        // Process your data here...

        return response()->json(['message' => 'Data received successfully', 'data' => $data], 200);

    }
}

