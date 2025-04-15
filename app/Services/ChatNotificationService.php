<?php

namespace App\Services;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Mail;

class ChatNotificationService
{
    public function notifyParticipants(ChatMessage $message)
    {
        $notifiableUsers = $message->list->getNotifiableUsers($message->user_id);

        foreach ($notifiableUsers as $user) {
            Mail::to($user->email)->send(new \App\Mail\NewChatMessage($message, $user));
        }
    }
}
