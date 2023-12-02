<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ScheduledEventHandler;
use App\Http\Controllers\ScheduledEventDeactivator;
use App\Events\DeviceUpdateEvent;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\AppUtilities;
use Illuminate\Support\Facades\Validator;
use App\Events\Modes\ToggleModeEvent;

class ToggleController extends Controller
{
    public $scheduledEventHandler;
    public $scheduledEventDeactivator;

    public function __construct(ScheduledEventHandler $scheduledEventHandler, ScheduledEventDeactivator $scheduledEventDeactivator)
    {
        $this->scheduledEventHandler = $scheduledEventHandler;
        $this->scheduledEventDeactivator = $scheduledEventDeactivator;
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
            'home_id' => 'required|integer',
            'mode_id' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if($data['is_active'] == true){
            $this->scheduledEventHandler->handleDaily($data['mode_id']);
            return response()->json(['message' => 'data sent'], 200);
        }
        else if($data['is_active'] == false){
            $this->scheduledEventDeactivator->deactivateDaily($data['mode_id']);
            return response()->json(['message' => 'data sent'], 200);
        }
    }
}
