<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * List users who have chatted
     */
    /**
     * List users who have chatted
     */
    public function index()
    {
        $users = $this->getChatUsers();
        $activeUser = null;
        $messages = [];

        return view('admin.chat.index', compact('users', 'activeUser', 'messages'));
    }

    /**
     * Show chat history with a user
     */
    public function show($userId)
    {
        $users = $this->getChatUsers();
        $activeUser = User::findOrFail($userId);

        // Mark messages as read
        ChatMessage::where('user_id', $userId)
            ->where('sender_type', 'user')
            ->update(['is_read' => true]);

        $messages = ChatMessage::where('user_id', $userId)
            ->oldest()
            ->get();

        return view('admin.chat.index', compact('users', 'activeUser', 'messages'));
    }

    private function getChatUsers()
    {
        return User::whereHas('chatMessages')
            ->withCount([
                'chatMessages as unread_count' => function ($query) {
                    $query->where('is_read', false)->where('sender_type', 'user');
                }
            ])
            ->orderByDesc(
                ChatMessage::select('created_at')
                    ->whereColumn('user_id', 'users.id')
                    ->latest()
                    ->limit(1)
            )
            ->paginate(20);
    }

    /**
     * Send message to user
     */
    public function store(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $message = ChatMessage::create([
            'user_id' => $userId,
            'sender_type' => 'admin',
            'message' => $request->message,
            'is_read' => false, // User hasn't read it yet
        ]);

        // Broadcast event
        broadcast(new MessageSent($message))->toOthers();

        return back();
    }
}
