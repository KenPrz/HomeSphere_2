<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class NotificationHandler extends Controller
{
    public function getNotifications(Request $request)
    {
        $request->validate([
            "user_id"=> "required|integer",
        ]);
        $user = User::find($request->user_id);
        return response()->json([
            'notifications' => $user->notifications()
        ]);
    }
}
