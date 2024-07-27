<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function get(Request $request, $chat_id)
    {

        $chat = Chat::find($chat_id);
        $messages = Message::where('chat_id', $chat_id)->get();
        return response()->json($messages, 200);
    }
   
}