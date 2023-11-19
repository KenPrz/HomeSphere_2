<?php

namespace App\Http\Controllers;

use App\Events\DeviceUpdateEvent;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToggleController extends Controller
{
    public function deviceToggle(Request $request)
    {
        $data = $this->validate($request, [
            'device_id' => 'required|integer',
            'is_active' => 'required|boolean',
            'room_id' => 'required|integer',
        ]);
        
        $device = Device::where('id', $data['device_id'])
            ->update(['is_active' => $data['is_active']]);

        if($device){
            event(new DeviceUpdateEvent($data['room_id'],$data['device_id'],$data['is_active']));
            return response()->json(['message' => $data], 200);
        } else {
            return response()->json(['message'=> 'Internal Server Error'],500);
        }
    }
}
