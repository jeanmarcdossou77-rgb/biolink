<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function sendRequest($userId)
    {
        $existing = Friendship::where('user_id', Auth::id())
            ->where('friend_id', $userId)->first();

        if (!$existing) {
            Friendship::create([
                'user_id' => Auth::id(),
                'friend_id' => $userId,
                'status' => 'pending',
            ]);
        }

        return redirect()->back()->with('success', '✅ Demande d\'ami envoyée !');
    }

    public function accept($id)
    {
        $friendship = Friendship::findOrFail($id);
        $friendship->update(['status' => 'accepted']);

        Auth::user()->increment('amis_count');
        $friendship->user->increment('amis_count');

        return redirect()->back()->with('success', '✅ Ami accepté !');
    }

    public function reject($id)
    {
        Friendship::findOrFail($id)->delete();
        return redirect()->back()->with('success', '❌ Demande rejetée.');
    }

    public function requests()
    {
        $requests = Friendship::where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('social.friend-requests', compact('requests'));
    }
}