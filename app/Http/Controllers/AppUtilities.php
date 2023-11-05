<?php

namespace App\Http\Controllers;

use App\Models\Api_key;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\apiKeyController;
class AppUtilities extends Controller
{
    /**
     * Find home data for a given user.
     *
     * @param  $user
     * @return mixed
     */
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
    
    /**
     * Returns the API key for the given home data.
     *
     * @param mixed $homeData The data of the home.
     * @return string The API key.
     */
    public function getApiKey($homeData){
        $apiKey = New apiKeyController;
        $key = $apiKey->getMyKey($homeData);
        return $key;
    }

    /**
     * Retrieve all members of a home.
     *
     * @param int $homeId The ID of the home to retrieve members for.
     * @return \Illuminate\Support\Collection A collection of home members, each containing the member's ID, first name, last name, profile image, role, and join date.
     */
    public function getHomeMembers($homeId){
        $homeMembers = DB::table('home_members')
                ->join('users', 'home_members.member_id', '=', 'users.id')
                ->select('users.id', 'users.firstName', 'users.lastName','users.profile_image', 'home_members.role', 'home_members.joined_on')
                ->where('home_members.home_id', $homeId)
                ->orderBy('home_members.role','asc')
                ->get();

        return $homeMembers;
    }
}
