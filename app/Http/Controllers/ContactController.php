<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserConnection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        //dd($contactId);
        $contact = User::find($contactId);
        $connection = new UserConnection();
        $connection->user_id = $user->id;
        $connection->connected_user_id = $contact->id;
        $connection->status = 'pending';
        $connection->save();
        
        return response()->json($contact);
    }
}
