<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Notification extends Component
{
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }
    #[On('refreshNotifications')]

    public function refreshNotifications()
    {
        $this->loadNotifications();
    }
    public function loadNotifications()
    {
        $this->notifications = Auth::user()->Notifications()->latest()->take(5)->get();
    }
    public function readAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }
    public function markAsRead($id)
    {
        Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
        $this->loadNotifications();
    }
    public function deleteNotification($id)
    {
        Auth::user()->Notifications()->where('id', $id)->delete();
        $this->loadNotifications();
    }
    public function deleteAll()
    {
        Auth::user()->notifications()->delete();
        $this->loadNotifications(); // Refresh the list
    }
    public function render()
    {
        return view('livewire.notification');
    }
}
