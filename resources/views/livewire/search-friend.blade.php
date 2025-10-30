<div>
    <div class="brutalist-sidebar__section">
        <div class="brutalist-search">
            <input wire:model.live= 'query' placeholder="Search" id="input" class="brutalist-search__input"
                name="text" type="text" />

            <label class="brutalist-label" for="input">
                <i class="brutalist-search__icon bi bi-search fs-5"></i>
            </label>
        </div>
        <div class="brutalist-sidebar__contacts-list">
            @if ($query == '')
                <div class="brutalist-empty-state">
                    <p>
                        Find someone to chat with</p>
                </div>
            @else
                @foreach ($results as $result)
                    <div class="brutalist-user-info brutalist-flex brutalist-flex--between">
                        <div class="brutalist-flex brutalist-flex--center">
                            <img class="brutalist-user-info__avatar" src="{{ getAvatar($result->name) }}"
                                alt="{{ $result->name }}">
                            <div class="brutalist-user-info__details">
                                <span class="brutalist-user-info__name">{{ $result->name }}</span>
                                <span
                                    class="brutalist-user-info__status">{{ $result->is_online ? 'Online' : 'Offline' }}</span>
                            </div>
                        </div>
                        @if ($this->isFriend($result))
                            <button class="brutalist-btn brutalist-btn--secondary brutalist-btn--sm" disabled>
                                <i class="bi bi-check-circle"></i>
                            </button>
                        @else
                            <button wire:click="addFriend({{ $result->id }})" class="brutalist-btn brutalist-btn--sm">
                                <i class="bi bi-person-plus"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="brutalist-sidebar__section-header">
            <h4 class="brutalist-sidebar__section-title">Direct Messages</h4>
            <div class="brutalist-toggle">
                <input type="checkbox" id="hideFriendsToggle" wire:model.live="checkboxChecked">
                <label for="hideFriendsToggle"></label>
            </div>
        </div>
        <div class="contacts-list">
            @if ($checkboxChecked)
                <div class="brutalist-empty-state">
                    <p>Friends hidden</p>
                </div>
            @else
                @if ($friends->isNotEmpty())
                    @foreach ($friends as $friend)
                        <livewire:friend-list :friend="$friend" :key="$friend->id" />
                    @endforeach
                @else
                    <div class="brutalist-empty-state">
                        <p>There are no friends</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <style>
        /* From Uiverse.io by Shaidend */
        .InputContainer {
            height: 40px;
            width: 90%;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            padding: 0 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.075);
        }

        .input {
            width: 170px;
            height: 100%;
            border: none;
            outline: none;
            font-size: 0.9em;
            caret-color: rgb(255, 81, 0);
        }

        .labelforsearch {
            cursor: pointer;
            padding: 0 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .searchIcon {
            font-size: 16px;
            color: rgb(114, 114, 114);
        }

        .border {
            height: 40%;
            width: 1.3px;
            background-color: rgb(223, 223, 223);
        }

        .micIcon {
            width: 12px;
        }

        .micButton {
            padding: 0px 15px 0px 12px;
            border: none;
            background-color: transparent;
            height: 40px;
            cursor: pointer;
            transition-duration: 0.3s;
        }

        .searchIcon path {
            fill: rgb(114, 114, 114);
        }

        .micIcon path {
            fill: rgb(255, 81, 0);
        }

        .micButton:hover {
            background-color: rgb(255, 230, 230);
            transition-duration: 0.3s;
        }
    </style>
    <style>
        .checkbox-container input {
            opacity: 0;
            cursor: pointer;
            width: 0;
            height: 0;
        }

        .checkbox-container {
            display: block;
            position: relative;
            cursor: pointer;
            font-size: 5px;
            user-select: none;
            width: 15px;
            height: 15px;
            border-radius: 3px;
            background: rgba(216, 216, 216, 0.603);
        }

        .checkbox-container:hover {
            background: rgba(197, 197, 197, 0.527);
        }

        .line {
            width: calc(100% - 8px);
            height: 3px;
            left: 4px;
            background: rgb(58, 58, 58);
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            transition: .7s transform cubic-bezier(0, 1, .33, 1.2), background .4s;
        }

        .line-indicator {
            transform: translateY(-50%) rotate(90deg);
        }

        .checkbox-container input:checked~.line-indicator {
            transform: translateY(-50%);
        }
    </style>
</div>
