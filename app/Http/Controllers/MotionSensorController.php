<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotionSensorController extends Controller
{
    public function toggleMotionSensor(Request $request)
{
    $request->validate([
        "motionSensorId" => "required",
        "is_active" => "required|boolean"
    ]);
    $data = DB::table("motion_sensors")->where("id", $request->motionSensorId)->get();
    $result = DB::table('motion_sensors')->where('id', $request->motionSensorId)->update(['is_active' => $request->is_active]);
    if ($result) {
        return response()->json(['response' => 'Updated Successfully'], 200);
    } else {
        return response()->json([
            'error' => 'Motion sensor update failed',
            'message' => 'Unable to update motion sensor in the specified room',
            'details' => [
                'data' => $data,
                'result' => $result,
                'sent_data' => $request,
            ],
        ], 400);
    }
}

}
