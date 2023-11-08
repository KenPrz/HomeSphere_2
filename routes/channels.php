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

Broadcast::channel('home.{home_id}', function ($user, $home_id) {
    if ($user->id && $home_id) {
        return DB::table('home_members')
                    ->where('member_id', $user->id)  // Check if the user's ID matches 'member_id'
                    ->where('home_id', $home_id)     // Check if the home ID matches the specific home you're interested in
                    ->exists();
    }
    return false;
});

