<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Notification extends Component
{
    public $notifications = [];
    protected $listeners = ['refreshNotifications'];
    public function mount()
    {
        $this->loadNotifications();
    }
    public function refreshNotifications()
    {
        $this->loadNotifications();
    }
    public function loadNotifications()
    {
        $this->notifications = Auth::user()->notifications()->latest()->take(5)->get();
    }
    public function render()
    {
        return view('livewire.notification');
    }
}
