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
            'body' => $this->body,
        ]);
        event(new UserSendGroupMessage($message));
        if ($this->group->members && $this->group->members->count() > 0) {
            foreach ($this->group->members as $member) {
                if ($member && $member instanceof User)
                    $member->notify(new UserSentMessage(Auth::user(), $message));
            }
        }
        $this->reset('body');
    }
    public function render()
    {
        $this->messages = GroupMessage::where('group_id', $this->group->id)->orderBy('created_at', 'asc')->get();
        return view('livewire.group-messages');
    }
}
