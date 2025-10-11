<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection; // Keep Collection type-hint for stability
use Livewire\Attributes\On;

class ChatMessages extends Component
{
    public $friend;
    public $messages;
    public $body;

    public function sendMessage()
    {
        $message = Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $this->friend->id,
            'body' => $this->body,
        ]);
        $this->reset('body');
    }
    public function render()
    {
        return view('livewire.chat-messages');
    }
}
