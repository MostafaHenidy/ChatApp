<?php

namespace App\Livewire;
use App\Notifications\UserSentMessage;
use App\Events\UserSendMessage;
use App\Models\Conversation;
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
    public $conversation;
    protected $listeners = ['userSendMessage' => '$refresh'];
    public function mount()
    {
        $userIds = [Auth::id(), $this->friend->id];
        sort($userIds); // ensures consistent order (e.g. always "1and2" not "2and1")

        $name = implode('and', $userIds);

        $this->conversation = Conversation::firstOrCreate([
            'name' => $name,
        ]);
    }
    #[On('userSendMessage')]
    public function refreshMessages($messageData)
    {
        $this->messages = Message::where('conversation_id', $this->conversation->id)->orderBy('created_at', 'asc')->get();
    }
    public function sendMessage()
    {
        $userIds = [Auth::id(), $this->friend->id];
        sort($userIds);
        $name = implode('and', $userIds);

        $this->conversation = Conversation::firstOrCreate([
            'name' => $name,
        ]);
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->friend->id,
            'body' => $this->body,
            'conversation_id' => $this->conversation->id,
            'group_id' => null ,
        ]);
        broadcast(new UserSendMessage($message))->toOthers();

        // Send notification safely
        $this->friend->notify(new UserSentMessage($message, Auth::user()));
        $this->dispatch('refreshFriendList');
        $this->reset('body');
    }
    public function render()
    {
        $this->messages = Message::where('conversation_id', $this->conversation->id)->orderBy('created_at', 'asc')->get();
        return view('livewire.chat-messages');
    }
}
