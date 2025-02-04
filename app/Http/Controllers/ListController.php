<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\Request;
use App\Models\MovieListItem;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;

class ListController extends Controller
{
    public function index()
    {
        // Récupérer les listes de l'utilisateur authentifié
        $lists = MovieList::where('owner_id', Auth::id())->get();
        // Récupérer les items de la liste pour afficher un poster
        foreach($lists as $list)
        {
            $listItem = MovieListItem::where('list_id', $list->id)->first();
            $movie = Movie::where('id', $listItem->movie_id)->get();
        }
        dd($movie);
        return response()->json($lists);
    }

    public function store(Request $request)
    {
        // Valider les données
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Créer une nouvelle liste
        $list = new MovieList();
        $list->name = $request->name;
        $list->owner_id = Auth::id();
        $list->save();

        return response()->json($list);
    }

    public function addMovie(Request $request)
    {
        // On ajoute l'item à la table movies
        $movie = new Movie();
        $movie->title = $request->name;
        $movie->release_date = $request->release;
        $movie->poster_path = $request->poster;
        $movie->director = null;
        $movie->actors = null;
        $movie->tmdb_id = $request->tv_id;
        $movie->save();
        $tvId = $request->tv_id;
        $listId = $request->query('list');
        // Ajouter cette nouvelle entrée à la liste
        $listItem = new MovieListItem();
        $listItem->list_id = $listId;
        $listItem->movie_id = $movie->id;
        $listItem->added_by = Auth::id();
        $listItem->save();
        return response()->json($listItem);
    }
}
