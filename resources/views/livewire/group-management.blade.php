<div class="group-management-page">
    <div class="container">
        <main class="main-content">
            <div class="chat-header groupManagement">
                <div class="group-info">
                    <img src="{{ getAvatar(strtoupper($this->group->name)) }}" alt="{{ $this->group->name }}"
                        class="group-main-avatar">
                    <div class="group-text mt-3">
                        <h2 class="chat-name">{{ $this->group->name }}</h2>
                        <p class="member-count-summary">{{ count($this->group->members) }} members</p>
                        <div class="group-members-summary">
                        </div>
                    </div>
                </div>
            </div>

            <div class="group-management-panel mt-3">
                <div class="panel-section member-list-section">
                    <h3>Member List</h3>
                    <div class="search-box">
                        <input type="text" id="memberSearch"wire:model.live.debounce.250ms='queryForSearchMember'
                            placeholder="Search members...">
                        <i class="bi bi-search"></i>
                    </div>
                    <ul class="member-list" id="memberList">
                        {{-- members list if the query is empty --}}
                        @if (empty($this->queryForSearchMember))
                            @foreach ($this->group->members as $member)
                                <div class="member ">
                                    <div class="avatar-wrapper position-relative">
                                        <img class="group-avatar" src="{{ getAvatar(strtoupper($member->name)) }}"
                                            alt="{{ $member->name }}">
                                        <span class="status-dot {{ $member->is_online ? 'online' : 'offline' }}"></span>
                                    </div>
                                    <h6 class="group-name">
                                        @if ($member->id != auth()->user()->id)
                                            {{ $member->name }}
                                        @else
                                            <span>You</span>
                                        @endif
                                    </h6>
                                    @if (auth()->id() != $member->id && $this->group->created_by == auth()->id())
                                        <form wire:submit.prevent ="kickMember({{ $member->id }})">
                                            @csrf
                                            <button class="btn add-group-btn text-danger">
                                                <i class="bi bi-person-x-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            {{-- members list if the query is not empty --}}
                            @if (count($results) > 0)
                                @foreach ($results as $result)
                                    <div class="member">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper position-relative">
                                                <img class="group-avatar"
                                                    src="{{ getAvatar(strtoupper($result->name)) }}"
                                                    alt="{{ $result->name }}">
                                                <span
                                                    class="status-dot {{ $result->is_online ? 'online' : 'offline' }}"></span>
                                            </div>
                                            <h6 class="group-name mb-0 ms-2">
                                                @if ($result->id != auth()->user()->id)
                                                    {{ $result->name }}
                                                @else
                                                    <span>You</span>
                                                @endif
                                            </h6>
                                            @if (auth()->id() != $result->id && $this->group->created_by == auth()->id())
                                                <form wire:submit.prevent ="kickMember({{ $result->id }})">
                                                    @csrf
                                                    <button class="btn add-group-btn text-danger">
                                                        <i class="bi bi-person-x-fill"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="d-flex justify-content-center">
                                    <p>No member found with that name.</p>
                                </div>
                            @endif
                        @endif
                    </ul>
                </div>

                <div class="panel-section add-member-section">
                    <h3>Add Member</h3>
                    <div class="search-box">
                        <input type="text" id="addMemberSearch" wire:model.live.debounce.250ms='queryForAddMember'
                            placeholder="Search user to add...">
                        <i class="bi bi-search"></i>
                    </div>
                    <div class="suggested-users-container">
                        <h3>Suggested Users</h3>
                        <ul class="suggested-users" id="suggestedUsersList">
                            {{-- add members list if the query is empty --}}
                            @if (empty($this->queryForAddMember))
                                @foreach ($resultsForAddMember->take(5) as $friend)
                                    <div class="member">
                                        <div class="avatar-wrapper position-relative">
                                            <img class="group-avatar" src="{{ getAvatar(strtoupper($friend->name)) }}"
                                                alt="{{ $friend->name }}">
                                            <span
                                                class="status-dot {{ $friend->is_online ? 'online' : 'offline' }}"></span>
                                        </div>
                                        <h6 class="group-name">
                                            @if ($friend->id != auth()->user()->id)
                                                {{ $friend->name }}
                                            @else
                                                <span>You</span>
                                            @endif
                                        </h6>
                                        @if ($this->group->type == 'public' || $this->group->created_by == auth()->id())
                                            <form wire:submit.prevent ="addMember({{ $friend->id }})">
                                                @csrf
                                                <button class="btn add-group-btn">
                                                    <i class="bi bi-person-plus-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                {{-- add members list if the query is not empty --}}
                                @if (count($this->resultsForAddMember) > 0)
                                    @foreach ($this->resultsForAddMember as $result)
                                        <div class="member">
                                            <div class="avatar-wrapper position-relative">
                                                <img class="group-avatar"
                                                    src="{{ getAvatar(strtoupper($result->name)) }}"
                                                    alt="{{ $result->name }}">
                                                <span
                                                    class="status-dot {{ $result->is_online ? 'online' : 'offline' }}"></span>
                                            </div>
                                            <h6 class="group-name">
                                                @if ($result->id != auth()->user()->id)
                                                    {{ $result->name }}
                                                @else
                                                    <span>You</span>
                                                @endif
                                            </h6>
                                            <form wire:submit.prevent ="addMember({{ $result->id }})">
                                                @csrf
                                                <button class="btn add-group-btn">
                                                    <i class="bi bi-person-plus-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center">
                                        <p>No friends found with that name.</p>
                                    </div>
                                @endif
                            @endif
                        </ul>
                    </div>
                </div>

                @if (auth()->user()->id == $this->group->created_by)
                    <div class="panel-section group-settings-section">
                        <h3>Group Settings</h3>
                        <ul class="settings-list">
                            <li>
                                <span class="me-4">Group Privacy</span>
                                <label class="switch">
                                    <input type="checkbox" wire:model.boolean='groupPrivacy'
                                        wire:change ='changeGroupPrivacy'>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <span class="me-4">Admin Only Posts</span>
                                <label class="switch">
                                    <input type="checkbox" wire:model.boolean='adminOnlyPosts'
                                        wire:change ='changeGroupPostPermission'>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <button class="btn btn-danger leave-group-btn" wire:click ='leaveGroup'>
                                    <i class="bi bi-box-arrow-right"></i> Leave Group
                                </button>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>

        </main>

    </div>
</div>
