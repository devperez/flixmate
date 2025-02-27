<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ListShare;
use App\Models\MovieList;
use Illuminate\Http\Request;
use App\Models\UserConnection;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function searchEmail(Request $request)
    {
        $query = $request->query('query');
        $user = User::where('email', $query)->first();
        return response()->json($user);
    }

    public function addContact(Request $request)
    {
        $user = Auth::user();
        $contactId = $request->input('id');
        $contact = User::find($contactId);
        $connection = new UserConnection();
        $connection->user_id = $user->id;
        $connection->connected_user_id = $contact->id;
        $connection->status = 'pending';
        $connection->save();

        return response()->json($contact);
    }

    public function getPendingRequestsCount()
    {
        $user = Auth::user();
        $count = UserConnection::where('connected_user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        return response()->json($count);
    }

    public function getConnections()
    {
        $userId = Auth::id();
        $pendingConnections = UserConnection::where('connected_user_id', $userId)
            ->where('status', 'pending')
            ->with('user')
            ->get();
        $activeConnections = UserConnection::where(function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'accepted')
            ->with(['user', 'connectedUser'])
            ->get();

            $user = User::find($userId);

        return response()->json([
            'pendingConnections' => $pendingConnections,
            'activeConnections' => $activeConnections,
            'user' => $user
        ]);
    }

    public function acceptConnection(Request $request)
    {
        $connectionId = $request->input('id');
        $connection = UserConnection::find($connectionId);
        if ($connection) {
            $connection->status = 'accepted';
            $connection->save();
        }
        $newConnection = new UserConnection();
        $newConnection->user_id = $connection->connected_user_id;
        $newConnection->connected_user_id = $connection->user_id;
        $newConnection->status = 'accepted';
        $newConnection->save();

        return response()->json(['message' => 'Connexion acceptée']);
    }

    public function rejectConnection(Request $request)
    {
        $connectionId = $request->input('id');
        $connection = UserConnection::find($connectionId);
        if ($connection) {
            $connection->status = 'rejected';
            $connection->save();
        }
        return response()->json(['message' => 'Connexion rejetée']);
    }

    public function shareList(Request $request)
    {
        $listId = $request->listId;
        $contactIds = $request->contacts;

        // Valider les données reçues
        $request->validate([
            'listId' => 'required|exists:movie_lists,id',
            'contacts' => 'required|array',
            'contacts.*' => 'exists:users,id',
        ]);

        // Insérer les enregistrements de partage
        foreach ($contactIds as $contactId) {
            ListShare::create([
                'list_id' => $listId,
                'contact_id' => $contactId,
            ]);
        }

        return response()->json(['message' => 'Liste partagée']);
    }
}
