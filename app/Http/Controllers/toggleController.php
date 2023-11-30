<?php

namespace App\Http\Controllers;

use App\Events\DeviceUpdateEvent;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\Validator;

class ToggleController extends Controller
{
    private $appUtilities;
    public function __construct(AppUtilities $appUtilities)
    {
        $this->appUtilities = $appUtilities;
    }
    
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
    public function toggleMode(Request $request)
    {
        $data = $this->validate($request, [
            'mode_id' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);
        
        $mode = DB::table('modes')
            ->where('id', $data['mode_id'])
            ->update(['is_active' => $data['is_active']]);

        if($mode){
            return response()->json(['message' => $data], 200);
        } else {
            return response()->json(['message'=> 'Internal Server Error'],500);
        }
    }
}
