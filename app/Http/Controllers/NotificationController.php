<?php

namespace App\Http\Controllers;

use App\Models\NotificationBiolink;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = NotificationBiolink::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        NotificationBiolink::where('user_id', Auth::id())
            ->where('lue', false)
            ->update(['lue' => true]);

        return view('notifications.index', compact('notifications'));
    }

    public function count()
    {
        $count = NotificationBiolink::where('user_id', Auth::id())
            ->where('lue', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}