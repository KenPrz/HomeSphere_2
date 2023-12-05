<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class NotificationHandler extends Controller
{
    public function getNotifications($currentAuthenticatedUser)
    {
        $processedUserData = [];
    
        foreach ($currentAuthenticatedUser->notifications as $notification) {
            $notificationData = $notification->data;
            $userId = $notificationData['notification']['user'];
            $userDetails = User::find($userId);
    
            $processedUserData[] = [
                'notification' => [
                    'id' => $notification->id,
                    'read_at' => $notification->read_at,
                    'data' => $notificationData['notification'],
                ],
                'user_details' => $userDetails ? [
                    'name' => $userDetails->firstName . ' ' . $userDetails->lastName,
                    'photo' => $userDetails->profile_image,
                ] : null,
                'timestamps' => [
                    'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $notification->updated_at->format('Y-m-d H:i:s'),
                ],
            ];
        }
        return $processedUserData;
    }    
}
