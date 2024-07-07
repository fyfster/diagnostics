<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends MyController
{
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)
            ->whereNull('read_at')
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead()
    {
        Notification::where('user_id', Auth::user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
