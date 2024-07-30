<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Chat;
use Dotenv\Validator;

class ChatController extends Controller
{
  public function getAllChats(Request $request, $id)
{
    $chats = Chat::where('user1', $id)
        ->orWhere('user2', $id)
        ->with(['user1Details', 'user2Details', 'messages' => function($query) {
            $query->latest()->first();
        }])
        ->get();

    $chats = $chats->map(function($chat) {
        $chat->latestMessage = $chat->messages->first() ? $chat->messages->first()->message : null;
        $chat->user1Name = $chat->user1Details->name;
        $chat->user2Name = $chat->user2Details->name;
        return $chat;
    });

    return response()->json($chats, 200);
}
    public function createChat(Request $request)
    {
        $request->validate([
            'user1' => 'required|exists:users,id',
            'user2' => 'required|exists:users,id',
        ]);

        // Check if the chat already exists
        $existingChat = Chat::where(function ($query) use ($request) {
            $query->where('user1', $request->user1)
                ->where('user2', $request->user2);
        })->orWhere(function ($query) use ($request) {
            $query->where('user1', $request->user2)
                ->where('user2', $request->user1);
        })->first();

        if ($existingChat) {
            return response()->json([
                'chat' => $existingChat,
                'message' => 'Chat already exists'
            ], 200);
        }

        // Create a new chat
        $chat = new Chat();
        $chat->user1 = $request->user1;
        $chat->user2 = $request->user2;
        $chat->save();

        return response()->json([
            'chat' => $chat,
            'message' => 'Chat created successfully'
        ], 201);
    }
}
