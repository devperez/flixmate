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

    public function shares()
    {
        return $this->hasMany(ListShare::class, 'list_id');
    }

    public function getNotifiableUsers(int $excludingUserId)
    {
        // Récupérer les utilisateurs avec qui la liste est partagée
        $users = $this->shares()->with('contact')->get()->pluck('contact');

        // Filtrer les utilisateurs, en excluant celui qui a envoyé le message
        $users = $users->filter(fn($user) => $user->id !== $excludingUserId);

        // Si le propriétaire n'est pas dans la liste, l'ajouter
        if ($this->owner && $this->owner->id !== $excludingUserId && !$users->contains('id', $this->owner->id)) {
            $users->push($this->owner);
        }

        return $users;
    }
}
