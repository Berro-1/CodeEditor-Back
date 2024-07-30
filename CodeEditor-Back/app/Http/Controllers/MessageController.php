<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getMessages($chat_id)
{
    $chat = Chat::with(['user1Details', 'user2Details'])->find($chat_id);
    if (!$chat) {
        return response()->json(['error' => 'Chat not found'], 404);
    }

    $messages = Message::where('chat_id', $chat_id)
        ->with('sender:id,name') // Ensure this line is correct
        ->get()
        ->map(function ($message) {
            return [
                'id' => $message->id,
                'chat_id' => $message->chat_id,
                'sender_id' => $message->sender_id,
                'sender_name' => $message->sender->name, // Include sender's name
                'message' => $message->message,
                'created_at' => $message->created_at,
                'updated_at' => $message->updated_at,
            ];
        });

    $chatDetails = [
        'chat_partner_name' => auth()->id() == $chat->user1 ? $chat->user2Details->name : $chat->user1Details->name,
        'messages' => $messages
    ];

    return response()->json($chatDetails);
}
    public function createMessage(Request $request, $chat_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $chat = Chat::find($chat_id);
        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }
    
        $message = new Message();
        $message->chat_id = $chat_id;
        $message->sender_id = auth()->id(); // Get the authenticated user's ID
        $message->message = $request->message;
        $message->save();
    
        return response()->json([
            'message' => $message,
        ], 201);
    }
    
}
