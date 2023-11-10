<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToggleController extends Controller
{
    public function toggle(Request $request)
    {
        $data = $this->validate($request, [
            'device_id' => 'required|integer',
            'is_active' => 'required|boolean'
        ]);

        $device = Device::where('id', $data['device_id'])
            ->update(['is_active' => $data['is_active']]);

        if($device){
            return response()->json(['message' => $device], 200);
        } else {
            return response()->json(['message'=> 'Internal Server Error'],500);
        }
    }
}
