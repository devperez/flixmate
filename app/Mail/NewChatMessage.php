<?php

namespace App\Mail;

use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $chatMessage;
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct(ChatMessage $chatMessage, User $user)
    {
        $this->chatMessage = $chatMessage;
        $this->user = $user;
    }
    

    public function build()
    {
        return $this->subject('Nouveau message dans une liste partagée')
                    ->view('emails.new-chat-message')
                    ->with([
                        'chatMessage' => $this->chatMessage,
                        'user' => $this->user,
                    ]);
    }
}
