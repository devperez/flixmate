<?php

namespace App\Http\Controllers;

use App\Models\ListShare;
use Inertia\Inertia;
use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\Request;
use App\Models\MovieListItem;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function index()
    {
        // Récupérer les listes de l'utilisateur authentifié
        $lists = MovieList::where('owner_id', Auth::id())->with(['items' => function ($query) {
            $query->with('movie');
        }])
            ->get();

        // Récupérer les listes partagées avec l'utilisateur authentifié
        $sharedLists = ListShare::where('contact_id', Auth::id())->with(['list' => function ($query) {
            $query->with('items.movie');
        }])
            ->get();

        return response()->json([
            'lists' => $lists,
            'sharedLists' => $sharedLists
        ]);
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
        // On ajoute l'item à la table movies s'il n'existe pas déjà
        if (!Movie::where('tmdb_id', $request->tv_id)->exists() ? !Movie::where('tmdb_id', $request->tv_id) : !Movie::where('tmdb_id', $request->movie_id)->exists()) {
            $movie = new Movie();
            $movie->tmdb_id = $request->tv_id ? $request->tv_id : $request->movie_id;
            $movie->title = $request->name ? $request->name : $request->title;
            $movie->release_date = $request->release;
            $movie->poster_path = $request->poster;
            $movie->director = null;
            $movie->actors = null;
            $movie->save();
        
            $listId = $request->query('list');
            // Ajouter cette nouvelle entrée à la liste
            $listItem = new MovieListItem();
            $listItem->list_id = $listId;
            $listItem->movie_id = $movie->id;
            $listItem->added_by = Auth::id();
            $listItem->save();
        }else{
            $movie = Movie::where('tmdb_id', $request->tv_id)->first() ? Movie::where('tmdb_id', $request->tv_id) : Movie::where('tmdb_id', $request->movie_id)->first();
            $listId = $request->query('list');
            // Ajouter cette nouvelle entrée à la liste
            $listItem = new MovieListItem();
            $listItem->list_id = $listId;
            $listItem->movie_id = $movie->id;
            $listItem->added_by = Auth::id();
            $listItem->save();
        }
        return response()->json($listItem);
    }

    public function show($id)
    {
        // Vérifier si l'utilisateur est le propriétaire de la liste
        $list = MovieList::with('items.movie')->find($id);

        if ($list && $list->owner_id === Auth::id()) {
            // L'utilisateur est le propriétaire, renvoyer la liste
            return Inertia::render('Show', ['list' => $list]);
        }

        // Vérifier si l'utilisateur a accès à la liste via un partage
        $sharedList = ListShare::where('list_id', $id)->where('contact_id', Auth::id())->first();

        if ($sharedList) {
            // L'utilisateur a accès à la liste via un partage, charger la liste associée
            $list = MovieList::with('items.movie')->find($id);
            return Inertia::render('Show', ['list' => $list]);
        }

        // Si l'utilisateur n'a pas accès à la liste, rediriger avec un message d'erreur
        return redirect()->route('lists.index')->with('error', 'Liste introuvable');
    }

    public function sharedWithContacts(Request $request)
    {
        $listId = $request->query('listId');
        // On récupère les partages de cette liste en bdd
        $shares = ListShare::where('list_id',$listId)->with('sharedWith')->get();
        $sharedContacts = $shares->pluck('sharedWith')->toArray();
        return response()->json(['sharedContacts' => $sharedContacts]);
    }

    public function delete(Request $request)
    {
        $listId = $request->query('list');
        $movieId = $request->query('movie');
        $movie = Movie::where('tmdb_id',$movieId)->first();
       // dd($movie);
        $listItem = MovieListItem::where('list_id', $listId)->where('movie_id', $movie->id)->first();
        $listItem->delete();
        return response()->json(['message' => 'Movie deleted']);
    }
}
