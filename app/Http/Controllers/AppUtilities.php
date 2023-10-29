<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppUtilities extends Controller
{
    public function findHomeData($user)
    {
        //this is for the owner
        $homeData = DB::table('homes')
                ->join('home_members', 'homes.id', '=', 'home_members.home_id')
                ->where('home_members.member_id', $user->id)
                ->select('homes.*', 'home_members.role')
                ->first();

        return $homeData;
    }
    
    public function getApiKey($homeData){
        $api_key = DB::table('home_api_keys')->where('home_id', $homeData->id)->first();
        return $api_key;
    }

    public function getHomeMembers($homeId){
        $homeMembers = DB::table('home_members')
                ->join('users', 'home_members.member_id', '=', 'users.id')
                ->select('users.id', 'users.firstName', 'users.lastName', 'home_members.role', 'home_members.joined_on')
                ->where('home_members.home_id', $homeId)
                ->orderBy('home_members.role','asc')
                ->get();

        return $homeMembers;
    }
}
