<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codesubmission extends Model

{
    protected $fillable = [
        'user_id',
        'code',
        
    ];
    use HasFactory;
    public function user()
    {
        $this->belongsTo(User::class);
    }
    
}
