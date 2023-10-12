<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppUtilities extends Controller
{
    public function findHomeData($user)
    {
        $homeData = DB::table('homes')->where('owner_id', $user->id)->first();
        if (!$homeData) {
            $homeMember = DB::table('home_members')->where('member_id', $user->id)->first();
            if ($homeMember) {
                $homeData = DB::table('homes')->where('id', $homeMember->home_id)->first();
            }
        }
        return $homeData;
    }
    public function getApiKey($homeData){
        $api_key = DB::table('home_api_keys')->where('home_id', $homeData->id)->first();
        return $api_key;
    }
}
