<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_date',
        'poster_path',
        'director',
        'actors',
        'tmdb_id',
        'metadata',
    ];

    public function listItems()
    {
        return $this->hasMany(MovieListItem::class, 'movie_id');
    }
}