<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListShare extends Model
{
    use HasFactory;

    protected $fillable = ['list_id', 'contact_id'];

    public function list()
    {
        return $this->belongsTo(MovieList::class);
    }

    public function contact()
    {
        return $this->belongsTo(User::class);
    }
}
