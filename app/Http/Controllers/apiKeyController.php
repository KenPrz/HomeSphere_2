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
        $randomString = Str::random(64);
    
        DB::table('home_api_keys')->insert([
            'home_id' => $homeData->id,
            'api_key' => $randomString,
        ]);
    
        return $randomString;
    }
}
