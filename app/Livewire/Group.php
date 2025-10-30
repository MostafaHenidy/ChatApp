<?php

namespace App\Livewire;

use App\Models\Group as ModelsGroup;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

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
            $this->selectedFriends = array_diff($this->selectedFriends, [$friendId]);
        } else {
            $this->selectedFriends[] = $friendId;
        }
    }
    public function createGroup()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'selectedFriends' => 'required|array|min:1',
        ]);

        $group = ModelsGroup::create([
            'name' => $this->name,
            'created_by' => Auth::id(),
        ]);

        $group->members()->attach($this->selectedFriends);
        $group->members()->attach(Auth::id(), ['is_admin' => true]);

        session()->flash('success', 'Group created successfully!');
        $this->reset(['name', 'selectedFriends']);
        $this->dispatch('groupCreated');
    }

    public function render()
    {
        return view('livewire.group');
    }
}
