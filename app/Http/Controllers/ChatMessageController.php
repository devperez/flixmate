<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ListShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($listId)
    {
        return ChatMessage::where('list_id', $listId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = new ChatMessage();
        $message->list_id = $request->listId;
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $listId)
    {
        $list = ListShare::findOrFail($listId);

        return view('chat.show', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
