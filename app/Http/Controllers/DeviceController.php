<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function deviceUpdate(Request $request){
        $request -> validate([
            'device_id' => 'required | numeric',
            'device_name' => 'required | string | max:20',
        ]);
        DB::table('devices')
            ->where('id', $request->device_id)
            ->update([
                'custom_name'=>$request->device_name,
            ]);
    }

    public function deviceDelete(Request $request){
        $request -> validate([
            'device_id' => 'required | numeric',
        ]);
        DB::table('devices')->where('id', $request->device_id)->delete();
    }
}
