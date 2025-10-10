<?php

namespace App\Livewire;

use Livewire\Component;

class UserInfo extends Component
{
    public $user;
    public $updateOnlineStatus;

    protected $listeners = ['userStatusUpdated' => 'updateUserInfo'];
    public function mount($user)
    {
        $this->user = $user;
        $this->updateOnlineStatus = $user->is_online; // initialize correctly
    }
    public function updateUserInfo()
    {
        $this->user->refresh(); // reload DB
        $this->updateOnlineStatus = $this->user->is_online;
    }
    public function render()
    {
        return view('livewire.user-info');
    }
}
