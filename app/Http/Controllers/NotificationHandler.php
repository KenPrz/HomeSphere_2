<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationHandler extends Controller
{
    public function getNotifications(Request $request)
    {
        return response()->json([
            'notifications' => $request->user()->notifications,
        ]);
    }
}
