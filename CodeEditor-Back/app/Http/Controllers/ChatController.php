<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Chat;
use Dotenv\Validator;

class ChatController extends Controller
{
    public function getAllChats(Request $request)
    {
        $chat = Chat::get();
        return response()->json($chat, 201);
    }
  
}
