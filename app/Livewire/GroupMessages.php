<?php

namespace App\Livewire;

use App\Events\UserSendGroupMessage;
use App\Notifications\UserSentMessage;
use App\Events\UserSendMessage;
use App\Models\Conversation;
use App\Models\GroupMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection; // Keep Collection type-hint for stability
use Livewire\Attributes\On;

class GroupMessages extends Component
{
    public $group;
    public $friend;
    public $messages;
    public $body;
    public $conversation;
    // public function mount()
    // {
    //     $userIds = [Auth::id(), $this->friend->id];
    //     sort($userIds);

    //     $name = implode('and', $userIds);

    //     $this->conversation = Conversation::firstOrCreate([
    //         'name' => $name,
    //     ]);
    // }
    #[On('userSendGroupMessage')]
    public function refreshMessages()
    {
        $this->messages = GroupMessage::where('group_id', $this->group->id)->orderBy('created_at', 'asc')->get();
    }
    public function sendMessage()
    {
        $message = GroupMessage::create([
            'group_id' => $this->group->id,
            'user_id' => Auth::user()->id,
            'message' => $this->body,
        ]);
        event(new UserSendGroupMessage($message));

        $this->reset('body');
    }
    public function render()
    {
        $this->messages = GroupMessage::where('group_id', $this->group->id)->orderBy('created_at', 'asc')->get();
        return view('livewire.group-messages');
    }
}
