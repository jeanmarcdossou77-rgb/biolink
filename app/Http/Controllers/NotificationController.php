<?php

namespace App\Http\Controllers;

use App\Models\NotificationBiolink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Marquer toutes comme lues
        NotificationBiolink::where('user_id', Auth::id())
            ->where('lu', false)
            ->update(['lu' => true]);

        $notifications = NotificationBiolink::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        NotificationBiolink::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['lu' => true]);

        return redirect()->back();
    }

    public function markAllRead()
    {
        NotificationBiolink::where('user_id', Auth::id())
            ->update(['lu' => true]);

        return response()->json(['success' => true]);
    }
}