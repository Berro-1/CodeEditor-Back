<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['user1', 'user2'];

    use HasFactory;

    public function user1Details()
    {
        return $this->belongsTo(User::class, 'user1');
    }
    
    public function user2Details()
    {
        return $this->belongsTo(User::class, 'user2');
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
}
