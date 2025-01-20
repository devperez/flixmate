<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'movie_id',
        'added_by',
        'status',
    ];

    public function movieList()
    {
        return $this->belongsTo(MovieList::class, 'list_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}