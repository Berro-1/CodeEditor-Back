<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chat;
class Message extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id', 'sender_id', 'message'];

    public function chat()
    {
        $this->belongsTo(Chat::class);
    }
}
