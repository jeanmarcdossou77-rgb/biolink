<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $userIds = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->get()
            ->map(function($msg) {
                return $msg->sender_id == Auth::id()
                    ? $msg->receiver_id
                    : $msg->sender_id;
            })
            ->unique()
            ->values();

        $conversations = collect();
        foreach ($userIds as $userId) {
            $lastMsg = Message::where(function($q) use ($userId) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
            })->orWhere(function($q) use ($userId) {
                $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
            })->latest()->first();

            if ($lastMsg) {
                $otherUser = User::find($userId);
                $conversations->push([
                    'user' => $otherUser,
                    'lastMsg' => $lastMsg,
                    'unread' => Message::where('sender_id', $userId)
                        ->where('receiver_id', Auth::id())
                        ->where('lu', false)->count()
                ]);
            }
        }

        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('social.messages', compact('conversations', 'users'));
    }

    public function conversation($userId)
    {
        $otherUser = User::findOrFail($userId);

        $messages = Message::where(function($q) use ($userId) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->update(['lu' => true]);

        $users = User::where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('social.conversation', compact('messages', 'otherUser', 'users'));
    }

    public function send(Request $request, $userId)
    {
        $request->validate(['contenu' => 'required|min:1']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'contenu' => $request->contenu,
            'lu' => false,
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'contenu' => $message->contenu,
                'sender_id' => $message->sender_id,
                'created_at' => $message->created_at->format('H:i'),
            ]
        ]);
    }

    public function adminView()
    {
        if (!Auth::user()->is_admin) abort(403);
        $conversations = Message::with(['sender', 'receiver'])
            ->latest()->paginate(50);
        return view('admin.messages', compact('conversations'));
    }
}