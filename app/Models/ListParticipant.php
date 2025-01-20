<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'user_id',
        'role',
    ];

    public function list()
    {
        return $this->belongsTo(MovieList::class, 'list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}