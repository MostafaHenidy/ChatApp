<div class="group-management-page">
    <div class="brutalist-sidebar__user-link">
        <div class="brutalist-user-info" style="justify-content: space-between; width: 100%;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <img class="brutalist-user-info__avatar" src="{{ getGroupAvatar(strtoupper($this->group->name)) }}"
                    alt="{{ $this->group->slug }}">
                <div class="brutalist-user-info__details">
                    <span class="brutalist-user-info__name">{{ strtoupper($group->name) }}</span>
                    <span class="brutalist-user-info__status">{{ $group->members->count() }} members</span>
                </div>
            </div>
        </div>
    </div>
    <div class="brutalist-grid">
        <div class="brutalist-card">
            <div class="brutalist-card__header">
                <h3 class="brutalist-mb">Member List</h3>
                <div class="brutalist-search">
                    <input class="brutalist-search__input" type="text"
                        id="memberSearch"wire:model.live.debounce.250ms='queryForSearchMember'
                        placeholder="Search members...">
                    <label class="brutalist-label" for="input">
                        <i class="brutalist-search__icon bi bi-search fs-5"></i>
                    </label>
                </div>
            </div>
            <div class="brutalist-card__body">
                <ul id="memberList" class="brutalist-member-list">
                    @if (empty($this->queryForSearchMember))
                        @foreach ($this->group->members as $member)
                            <li class="brutalist-user-row">
                                <div class="brutalist-user-info">
                                    <img class="brutalist-user-info__avatar"
                                        src="{{ getAvatar(strtoupper($member->name)) }}" alt="{{ $member->name }}">
                                    <div class="brutalist-user-info__details">
                                        <h6 class="brutalist-user-info__name">
                                            @if ($member->id != auth()->user()->id)
                                                {{ $member->name }}
                                            @else
                                                <span>You</span>
                                            @endif
                                        </h6>
                                        <span
                                            class="brutalist-user-info__status brutalist-user-info__status--{{ $member->is_online ? 'online' : 'offline' }}">
                                            {{ $member->is_online ? 'online' : 'offline' }}
                                        </span>
                                    </div>

                                    @if (auth()->id() != $member->id && $this->group->created_by == auth()->id())
                                        <form wire:submit.prevent ="kickMember({{ $member->id }})">
                                            @csrf
                                            <button class="brutalist-btn brutalist-btn--accent brutalist-btn--sm ">
                                                <i class="bi bi-person-x-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @else
                        @if (count($results) > 0)
                            @foreach ($results as $result)
                                <li class="brutalist-user-row">
                                    <div class="brutalist-user-info">
                                        <img class="brutalist-user-info__avatar"
                                            src="{{ getAvatar(strtoupper($result->name)) }}"
                                            alt="{{ $result->name }}">
                                        <div class="brutalist-user-info__details">
                                            <h6 class="brutalist-user-info__name">
                                                @if ($result->id != auth()->user()->id)
                                                    {{ $result->name }}
                                                @else
                                                    <span>You</span>
                                                @endif
                                            </h6>
                                            <span
                                                class="brutalist-user-info__status brutalist-user-info__status--{{ $result->is_online ? 'online' : 'offline' }}">
                                                {{ $result->is_online ? 'online' : 'offline' }}
                                            </span>
                                        </div>

                                        @if (auth()->id() != $result->id && $this->group->created_by == auth()->id())
                                            <form wire:submit.prevent ="kickMember({{ $result->id }})">
                                                @csrf
                                                <button class="brutalist-btn brutalist-btn--accent brutalist-btn--sm ">
                                                    <i class="bi bi-person-x-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <div class="brutalist-empty-state">
                                <p>No member found with that name.</p>
                            </div>
                        @endif
                    @endif
                </ul>
            </div>
        </div>

        <div class="brutalist-card">
            <div class="brutalist-card__header">
                <h3 class="brutalist-mb">Add Member</h3>
                <div class="brutalist-search">
                    <input class="brutalist-search__input" type="text" id="addMemberSearch"
                        wire:model.live.debounce.250ms='queryForAddMember' placeholder="Search user to add...">
                    <label class="brutalist-label" for="input">
                        <i class="brutalist-search__icon bi bi-search fs-5"></i>
                    </label>
                </div>
            </div>
            <div class="brutalist-card__body">
                <div class="brutalist-mb"
                    style="border-bottom: var(--border-width) solid var(--color-border, #000000); ">
                    <h5>Suggested Users</h5>
                </div>
                <ul id="suggestedUsersList" class="brutalist-member-list">
                    {{-- add members list if the query is empty --}}
                    @if (empty($this->queryForAddMember))
                        @foreach ($resultsForAddMember->take(5) as $friend)
                            <li class="brutalist-user-row">
                                <div class="brutalist-user-info">
                                    <img class="brutalist-user-info__avatar"
                                        src="{{ getAvatar(strtoupper($friend->name)) }}" alt="{{ $friend->name }}">
                                    <div class="brutalist-user-info__details">
                                        <h6 class="brutalist-user-info__name">
                                            @if ($friend->id != auth()->user()->id)
                                                {{ $friend->name }}
                                            @else
                                                <span>You</span>
                                            @endif
                                        </h6>
                                        <span
                                            class="brutalist-user-info__status brutalist-user-info__status--{{ $friend->is_online ? 'online' : 'offline' }}">
                                            {{ $friend->is_online ? 'online' : 'offline' }}
                                        </span>
                                    </div>
                                    @if ($this->group->type == 'public' || $this->group->created_by == auth()->id())
                                        <form wire:submit.prevent ="addMember({{ $friend->id }})">
                                            @csrf
                                            <button class="brutalist-btn brutalist-btn--sm">
                                                <i class="bi bi-person-plus-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @else
                        {{-- add members list if the query is not empty --}}
                        @if (count($this->resultsForAddMember) > 0)
                            @foreach ($this->resultsForAddMember as $result)
                                <li class="brutalist-user-row">
                                    <div class="brutalist-user-info ">
                                        <img class="brutalist-user-info__avatar"
                                            src="{{ getAvatar(strtoupper($result->name)) }}"
                                            alt="{{ $result->name }}">
                                        <div class="brutalist-user-info__details">
                                            <h6 class="brutalist-user-info__name">
                                                @if ($result->id != auth()->user()->id)
                                                    {{ $result->name }}
                                                @else
                                                    <span>You</span>
                                                @endif
                                            </h6>
                                            <span
                                                class="brutalist-user-info__status brutalist-user-info__status--{{ $result->is_online ? 'online' : 'offline' }}">
                                                {{ $result->is_online ? 'online' : 'offline' }}
                                            </span>
                                        </div>
                                        <form wire:submit.prevent ="addMember({{ $result->id }})">
                                            @csrf
                                            <button class="brutalist-btn brutalist-btn--sm">
                                                <i class="bi bi-person-plus-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        @else
                        @endif
                    @endif
                </ul>
            </div>
        </div>

        @if (auth()->user()->id == $this->group->created_by)
            <div class="brutalist-card">
                <div class="brutalist-card__header">
                    <h3>Group Settings</h3>
                </div>
                <div class="brutalist-card__body">
                    <ul class="brutalist-member-list">
                        <li class="brutalist-user-row">
                            <div class="brutalist-toggle managePage brutalist-mt">
                                <label>
                                    <span class="me-4">Group Privacy</span>
                                </label>
                                <input type="checkbox" wire:model.boolean='groupPrivacy'
                                    wire:change ='changeGroupPrivacy'>
                            </div>
                        </li>
                        <li class="brutalist-user-row">
                            <div class="brutalist-toggle managePage brutalist-mt">
                                <label class="switch">
                                    <span class="me-4">Admin Only Posts</span>
                                </label>
                                <input type="checkbox" wire:model.boolean='adminOnlyPosts'
                                    wire:change ='changeGroupPostPermission'>
                            </div>
                        </li>
                        <form wire:submit.prevent="uploadGroupAvatar" enctype="multipart/form-data"
                            class="brutalist-upload-form">
                            @csrf
                            <li class="brutalist-user-row brutalist-upload-row">
                                <div class="brutalist-file-upload">
                                    <label for="avatar" class="brutalist-file-upload__label">
                                        <div class="brutalist-file-upload__icon">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                        </div>
                                        <div>
                                            <div class="brutalist-file-upload__text">Click or drag an image to upload
                                            </div>
                                            <div class="brutalist-file-upload__hint">Supported: JPG, PNG — Max 1MB
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" wire:model="avatar" id="avatar" accept="image/*"
                                        class="brutalist-file-upload__input">
                                    <x-input-error class="brutalist-input--error" :messages="$errors->get('avatar')" />
                                </div>
                            </li>

                            <button class="brutalist-btn brutalist-upload-btn">
                                <i class="bi bi-upload me-2"></i> Upload Avatar
                            </button>
                        </form>
                        <li class="brutalist-user-row">
                            <button class="brutalist-btn brutalist-btn--accent brutalist-mt" wire:click ='leaveGroup'>
                                <i class="bi bi-box-arrow-right"></i> Leave Group
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </div>

</div>
