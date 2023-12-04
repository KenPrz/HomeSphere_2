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
}
