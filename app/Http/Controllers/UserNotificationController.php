<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class UserNotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications->where('id', $request->notification_id)->markAsRead();
    }
    public function markAllRead(Request $request){
        $user = auth()->user();
        if($request->user_id == $user->id){
            $user->unreadNotifications->markAsRead();
        }
    }
}