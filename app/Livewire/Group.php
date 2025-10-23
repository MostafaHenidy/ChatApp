<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Group extends Component
{
    public $name;
    public $friends;
    public $selectedFriends = [];
    public function mount()
    {
        $this->friends = Auth::user()->friends()->get();
    }
    public function toggleFriend($friendId)
    {
        if (in_array($friendId, $this->selectedFriends)) {
            // Remove friend if already selected
            $this->selectedFriends = array_diff($this->selectedFriends, [$friendId]);
        } else {
            // Add friend if not selected
            $this->selectedFriends[] = $friendId;
        }
    }
    public function createGroup()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'selectedFriends' => 'required|array|min:1',
        ]);

        $group = \App\Models\Group::create([
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'created_by' => auth()->id(),
        ]);

        $group->members()->attach(array_merge($this->selectedFriends, [auth()->id()]));

        session()->flash('success', 'Group created successfully!');
        $this->reset(['name', 'selectedFriends']);
        $this->dispatch('groupCreated'); // optional event
    }

    public function render()
    {
        return view('livewire.group');
    }
}
