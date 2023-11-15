<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('room.{room_id}', function ($user, $room_id) {
    if ($user->id && $room_id) {
        $home_id = DB::table('home_members')->where('member_id', $user->id)->value('home_id');
        if ($home_id) {
            $is_member = DB::table('rooms')->where('home_id', $home_id)->exists();
            if ($is_member) {
                return true;
            }
        }
    }
    return false;
});

Broadcast::channel('home.{home_id}', function($user, $home_id){
    if ($user->id && $home_id) {
        $is_member = DB::table('home_members')->where('home_id', $home_id)->where('member_id', $user->id)->exists();
        if ($is_member) {
            return true;
        }
    }
    return false;
});


