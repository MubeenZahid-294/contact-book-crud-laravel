<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::owned()
            ->latest()
            ->take(20)
            ->get();

        // Mark all as read
        Notification::owned()->unread()->update(['is_read' => true]);

        return response()->json($notifications);
    }

    public function markAllRead()
    {
        Notification::owned()->unread()->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function destroy(Notification $notification)
    {
        abort_if($notification->user_id !== auth()->id(), 403);
        $notification->delete();
        return response()->json(['success' => true]);
    }

    public function count()
    {
        $count = Notification::owned()->unread()->count();
        return response()->json(['count' => $count]);
    }
}