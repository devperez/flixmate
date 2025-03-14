<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['list_id', 'user_id', 'message'];

    public function list()
    {
        return $this->belongsTo(MovieList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
