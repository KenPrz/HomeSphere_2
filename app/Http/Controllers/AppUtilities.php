<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppUtilities extends Controller
{
    public function findHomeData($user)
    {
        $homeData = DB::table('homes')
            ->where('owner_id', $user->id)
            ->select('*', DB::raw('1 as is_owner'))
            ->first();
    
        if (!$homeData) {
            $homeData = DB::table('homes')
                ->join('home_members', 'homes.id', '=', 'home_members.home_id')
                ->where('home_members.member_id', $user->id)
                ->select('homes.*', 'home_members.is_owner')
                ->first();
        }
        return $homeData;
    }
    
    public function getApiKey($homeData){
        $api_key = DB::table('home_api_keys')->where('home_id', $homeData->id)->first();
        return $api_key;
    }
}
