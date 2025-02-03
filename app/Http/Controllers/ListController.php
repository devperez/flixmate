<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function index()
    {
        // Récupérer les listes de l'utilisateur authentifié
        $lists = MovieList::where('owner_id', Auth::id())->get();

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
}
