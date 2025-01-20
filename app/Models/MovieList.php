<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'metadata',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function participants()
    {
        return $this->hasMany(ListParticipant::class, 'list_id');
    }

    public function items()
    {
        return $this->hasMany(MovieListItem::class, 'list_id');
    }
}