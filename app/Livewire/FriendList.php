<?php

namespace App\Livewire;

use Livewire\Component;

class FriendList extends Component
{
    public $friend;
    public $updateOnlineStatus;
    protected $listeners = ['userStatusUpdated' => 'updateUserStatus'];
    public function mount($friend)
    {
        $this->friend = $friend;
        $this->updateOnlineStatus = $friend->is_online;
    }
    public function updateUserStatus()
    {
        $this->friend->refresh();
        $this->updateOnlineStatus = $this->friend->is_online;
    }
    public function render()
    {
        return view('livewire.friend-list');
    }
}
