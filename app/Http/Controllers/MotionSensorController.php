<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MotionSensorController extends Controller
{
    public function toggleMotionSensor(Request $request)
    {
        $request->validate([
            "roomId" => "required|numeric",
            "homeId" => "required|numeric",
            "userId" => "required|numeric",
            "motionSensorId" => "required|numeric",
            "is_active" => "required|boolean"
        ]);

        try {
            // Use transactions for atomicity
            DB::beginTransaction();

            // Check if the motion sensor exists
            $motionSensorExists = DB::table("motion_sensors")
                ->where("id", $request->motionSensorId)
                ->where("room_id", $request->roomId) // Add a check for the room if needed
                ->exists();

            if (!$motionSensorExists) {
                return response()->json(["error" => "Motion sensor not found"], 404);
            }

            // Check if the user is a member of the home
            $isMember = DB::table("home_members")
                ->where("home_id", $request->homeId)
                ->where("member_id", $request->userId)
                ->exists();

            if (!$isMember) {
                return response()->json(['error' => 'Unauthorized', 'message' => 'You are not a member of this home'], 401);
            }

            // Update motion sensor state
            $result = DB::table('motion_sensors')
                ->where('id', $request->motionSensorId)
                ->update(['is_active' => $request->is_active]);

            if ($result) {
                // Commit the transaction
                DB::commit();

                return response()->json(['response' => 'Updated Successfully'], 200);
            } else {
                // Rollback the transaction
                DB::rollBack();

                return response()->json([
                    'error' => 'Motion sensor update failed',
                    'message' => 'Unable to update motion sensor in the specified room',
                ], 400);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            DB::rollBack();

            return response()->json([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
