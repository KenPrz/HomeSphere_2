<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\DeviceUpdateEvent;
use App\Events\Modes\ToggleModeEvent;
class ScheduledEventDeactivator extends Controller
{
    public function deactivate($mode){
        if($mode->frequency=='daily'){
            $this->deactivateDaily($mode->mode_id);
        }else if($mode->frequency== 'weekly'){
            $this->deactivateWeekly($mode);
        }else{
            return response()->json(['status'=> 'error', 'message'=> 'Invalid frequency.']);
        }
    }
    public function deactivateDaily($mode_id){
        $is_mode_active = DB::table('modes')->where('id', $mode_id)->value('is_active');
        if($is_mode_active==true){
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
    private function deactivateWeekly($scheduledMode){
        $currentDayOfWeek = Carbon::now('Asia/Manila')->dayName;
        $scheduledDays = json_decode($scheduledMode->days_of_week, true);
        if (is_array($scheduledDays) && in_array(strtolower($currentDayOfWeek), $scheduledDays)) {
            $this->deactivateDaily($scheduledMode);
        } else {
            echo "Today is not a scheduled day for.\n";
        }
    }
    private function deviceHandle($device_id, $is_active){
        $room_id = DB::table('devices')->where('id', $device_id)->value('room_id');
        $liveState = DB::table('devices')->where('id', $device_id)->value('is_active');
        if($liveState == $is_active){
            DB::table("devices")->where("id", $device_id)->update([
                "is_active" => !$is_active,
                "updated_at" => now()
            ]);
            event(new DeviceUpdateEvent($room_id,$device_id,!$is_active));
        }
    }
}
