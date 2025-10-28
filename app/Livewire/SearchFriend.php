<?php

namespace App\Livewire;

use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Livewire\Attributes\On;
use Livewire\Component;

class SearchFriend extends Component
{
    public $query = '';
    public $friends;
    public $messages;
    public $checkboxChecked = false;
    public function mount()
    {
        $this->loadFriends();
    }
    #[On('refreshFriendList')]
    #[On('echo:UserSendMessage,UserSendMessage')]
    public function loadFriends()
    {
        $user = Auth::user()->fresh();
        $userId = $user->id;

        $friendIds = $user->allFriends()->pluck('id');

        $this->friends = User::whereIn('id', $friendIds)
            ->select('users.*')
            ->addSelect([
                'last_message_time' => Message::select('created_at')
                    ->where(function ($q) use ($userId) {
                        $q->whereColumn('sender_id', 'users.id')->where('receiver_id', $userId);
                    })
                    ->orWhere(function ($q) use ($userId) {
                        $q->whereColumn('receiver_id', 'users.id')->where('sender_id', $userId);
                    })
                    ->latest()
                    ->limit(1),
            ])
            ->orderByDesc('last_message_time')
            ->get();
    }
    public function addFriend($friendId)
    {
        Friend::firstOrCreate([
            'user_id' => Auth::user()->id,
            'friend_id' => $friendId,
        ]);
        Friend::firstOrCreate([
            'user_id' => $friendId,
            'friend_id' => Auth::user()->id,
        ]);
        $this->dispatch('refreshFriendList');
        $this->reset('query');
    }
    public function isFriend($friend)
    {
        return Auth::user()->friends()->where('users.id', $friend->id)->exists();
    }
    public function render()
    {
        $currentUser = Auth::user();
        $results = User::where('name', 'like', '%' . $this->query . '%')
            ->where('id', '!=', $currentUser->id)
            ->get();
        return view('livewire.search-friend', compact('results'));
    }
}
