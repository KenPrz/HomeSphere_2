<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Home;
use App\Events\DeviceUpdateEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\Modes\ToggleModeEvent;
use App\Notifications\ModesNotification;
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
            $homeId = DB::table('modes')->where('id', $mode_id)->value('home_id');
            
            event(new ToggleModeEvent($mode_id, true, $homeId));
            $user = auth()->user();
            if($user){
                $this->modeActivateNotification($homeId, $user->id, $mode_id);
            }
            else{
                $this->modeActivateNotification($homeId, null, $mode_id);
            }
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
    private function modeActivateNotification($home_id, $data, $mode_id){
        $mode = DB::table('modes')->where('id', $mode_id)->first();
        if($data!=null){
            $user = auth()->user();
            $notificationData = [
                'title' => 'Mode Activated',
                'body'=> 'has activated '.$mode->mode_name.'.',
                'user' => $user->id,
                'type' => 'activate'
            ];
            $home = Home::find($home_id);
            $members = $home->members->where('role', '!=', 'pending')->where('member_id', '!=', auth()->user()->id);
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new ModesNotification($notificationData));
            }
        }else{
            $notificationData = [
                'title' => 'Mode Activated',
                'body'=> 'has activated '.$mode->mode_name.'.',
                'user' => 'System: ',
                'type' => 'activate',
            ];
            $home = Home::find($home_id);
            $members = $home->members->where('role', '!=', 'pending');
            foreach ($members as $member) {
                $user = User::find($member->member_id);
                $user->notify(new ModesNotification($notificationData));
            }
        }

    }
}
