<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    /**
     * Get Chat History
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $messages = ChatMessage::where('user_id', $user->id)
            ->latest()
            ->paginate(50);

        return response()->json($messages);
    }

    /**
     * Send Message to Admin
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();

        $message = ChatMessage::create([
            'user_id' => $user->id,
            'sender_type' => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Broadcast event
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
    }
}
