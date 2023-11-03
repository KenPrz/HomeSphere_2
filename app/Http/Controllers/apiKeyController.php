<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class apiKeyController extends Controller
{
    public function getMyKey($homeData){
        return DB::table("home_api_keys")
            ->where('home_id',$homeData->id)
            ->first();
    }

    public function generateNewKey($homeData){
        $newKey = Str::random(64);
    
        $data = DB::table('home_api_keys')
        ->where('home_id', $homeData->id)
        ->update(['api_key' => $newKey, 'updated_at' => now()]);

        if($data){
            return $newKey;
        }else{
            return false;
        }
    }
}