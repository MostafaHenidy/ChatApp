<?php

namespace App\Livewire;

use Livewire\Component;

class GroupManagement extends Component
{
    public $group ;
    public $messages ;
    public function render()
    {
        return view('livewire.group-management');
    }
}
