<?php

namespace App\Livewire;

use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GroupManagement extends Component
{
    public $group;
    public $queryForSearchMember = '';
    public $queryForAddMember = '';

    public $results = [];
    public $resultsForAddMember = [];

    public $adminOnlyPosts = false;
    public  $groupPrivacy = true;

    public function mount()
    {
        if ($this->group->type == 'public') {
            $this->groupPrivacy = false;
        } else {
            $this->groupPrivacy = true;
        }
        if($this->group->admin_only_post = true){
            $this->adminOnlyPosts = true ; 
        }else{
            $this->adminOnlyPosts = false ; 
        }
    }
    public function addMember($id)
    {
        $friend = Auth::user()->friends()->where('users.id', $id)->first();
        $this->group->members()->attach($friend->id);
        $this->queryForAddMember = '';
        $this->group->refresh();
    }
    public function kickMember($id)
    {
        $member = $this->group->members()->where('users.id', $id)->first();
        $this->group->members()->detach($member->id);
        $this->queryForAddMember = '';
        $this->group->refresh();
    }
    public function changeGroupPrivacy()
    {
        if ($this->groupPrivacy == false) {
            $this->group->type = 'public';
            $this->group->save();
        } else {
            $this->group->type = 'private';
            $this->group->save();
        }
    }
    public function changeGroupPostPermission()
    {
        if ($this->adminOnlyPosts == false) {
            $this->group->admin_only_post = false;
            $this->group->save();
        } else {
            $this->group->admin_only_post = true;
            $this->group->save();
        }
    }
    public function leaveGroup()
    {
        $userId = Auth::id();

        $this->group->members()->detach($userId);

        $newAdmin = \App\Models\GroupMember::where('group_id', $this->group->id)
            ->orderBy('created_at', 'asc')
            ->first();

        if ($newAdmin) {
            $newAdmin->update(['is_admin' => true]);

            $this->group->update(['created_by' => $newAdmin->user_id]);
        } else {
            $this->group->delete();
        }

        $this->group->refresh();
    }
    public function render()
    {
        $this->group->load('members');

        $this->results = $this->group->members()
            ->where('users.name', 'like', '%' . $this->queryForSearchMember . '%')
            ->get();

        $memberIds = $this->group->members->pluck('id')->toArray();

        $this->resultsForAddMember = Auth::user()
            ->friends()
            ->whereNotIn('users.id', $memberIds)
            ->where('users.name', 'like', '%' . $this->queryForAddMember . '%')
            ->get();

        return view('livewire.group-management', [
            'results' => $this->results,
            'resultsForAddMember' => $this->resultsForAddMember,
        ]);
    }
}
