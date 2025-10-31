<?php

namespace App\Livewire;

use App\Models\GroupMember;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;


class GroupManagement extends Component
{
    use WithFileUploads;

    public $group;
    #[Validate('image|max:1024')]
    public $avatar;
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
        if ($this->group->admin_only_post = true) {
            $this->adminOnlyPosts = true;
        } else {
            $this->adminOnlyPosts = false;
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
    public function uploadGroupAvatar()
    {
        $userId = Auth::id();

        $isAdmin = GroupMember::where('group_id', $this->group->id)
            ->where('user_id', $userId)
            ->where('is_admin', true)
            ->exists();

        if ($this->avatar) {
            $this->group->clearMediaCollection('groups.avatars');
            $this->group
                ->addMedia($this->avatar)
                ->toMediaCollection('groups.avatars', 'public');

            $this->dispatch('showSuccess', 'Group avatar updated successfully!');
            $this->group->refresh();
        }
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
