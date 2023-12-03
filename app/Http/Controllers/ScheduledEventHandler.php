<?php

namespace App\Http\Controllers;
use App\Events\DeviceUpdateEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduledEventHandler extends Controller
{
    public function handleSchedule($scheduledMode){
        if($scheduledMode->frequency=='daily'){
            $this->handleDaily($scheduledMode->mode_id);
        }else if($scheduledMode->frequency== 'weekly'){
            $this->handleWeekly($scheduledMode);
        }else{
            return response()->json(['status'=> 'error', 'message'=> 'Invalid frequency.']);
        }
    }
    public function handleDaily($mode_id){
        $is_mode_active = DB::table('modes')->where('id', $mode_id)->value('is_active');
        if($is_mode_active==false){
            DB::table('modes')->where('id', $mode_id)
                ->update([
                'is_active' => true,
            ]);
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
    private function handleWeekly($scheduledMode){
        $currentDayOfWeek = Carbon::now('Asia/Manila')->dayName;
        $scheduledDays = json_decode($scheduledMode->days_of_week, true);
        if (is_array($scheduledDays) && in_array(strtolower($currentDayOfWeek), $scheduledDays)) {
            $this->handleDaily($scheduledMode->id);
        } else {
            echo "Today is not a scheduled day for.\n";
        }
    }
    private function deviceHandle($device_id, $is_active){
        $room_id = DB::table('devices')->where('id', $device_id)->value('room_id');
        DB::table("devices")->where("id", $device_id)->update([
            "is_active" => $is_active,
            "updated_at" => now()
        ]);
        $this->fireEvent($room_id,$device_id, $is_active);
    }
    private function fireEvent($room_id,$device_id,$is_active){
        event(new DeviceUpdateEvent($room_id, $device_id, $is_active));
        echo 'Event fired.';
    }
}
