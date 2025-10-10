<?php

namespace App\Livewire;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Livewire\Attributes\On;
use Livewire\Component;

class SearchFriend extends Component
{
    public $query = '';
    public function addFriend($friendId)
    {
        Friend::firstOrCreate([
            'user_id' => Auth::user()->id,
            'friend_id' => $friendId,
        ]);
        $this->reset('query');
    }
    public function isFriend($friend)
    {
        return Auth::user()->friends()->where('users.id', $friend->id)->exists();
    }
    public function render()
    {
        $currentUser  = Auth::user();
        $results =  User::where('name', 'like', '%' . $this->query . '%')
            ->where('id', '!=', $currentUser->id)->get();
        return view('livewire.search-friend', compact('results'));
    }
}
