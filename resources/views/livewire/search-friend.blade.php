<div>
    <div class="sidebar-section">
        <div class="InputContainer">
            <input wire:model.live= 'query' placeholder="Search" id="input" class="input" name="text"
                type="text" />

            <label class="labelforsearch" for="input">
                <i class="searchIcon bi bi-search"></i>
            </label>
        </div>
        <div class="contacts-list">
            @if ($query == '')
                <div class="empty-state">
                    <p>Find someone to chat with</p>
                </div>
            @else
                @foreach ($results as $result)
                    <div class="search-result-item">
                        <div class="search-user-info">
                            <div class="contact-avatar">
                                <img src="{{ getAvatar($result->name) }}" alt="{{ $result->name }}">
                                <span class="status-indicator {{ $result->is_online ? 'online' : 'offline' }}"></span>
                            </div>
                            <div class="contact-info">
                                <span class="contact-name">{{ $result->name }}</span>
                                <span class="contact-status">
                                    {{ $result->is_online ? 'Online' : 'Offline' }}
                                </span>
                            </div>
                        </div>
                        @if ($this->isFriend($result))
                            <button class="btn-already-friend" disabled>
                                <i class="bi bi-check-circle"></i> Already Friends
                            </button>
                        @else
                            <button wire:click="addFriend({{ $result->id }})" class="btn-add-friend">
                                <i class="bi bi-person-plus"></i> Add
                            </button>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="section-header">
            <h4 class="section-title">Direct Messages</h4>
            <label class="checkbox-container">
                <input type="checkbox" wire:model.live="checkboxChecked">
                <div class="line"></div>
                <div class="line line-indicator"></div>
            </label>
        </div>
        <div class="contacts-list">
            @if ($checkboxChecked)
                <div class="empty-state">
                    <p>Friends hidden</p>
                </div>
            @else
                @if ($friends->isNotEmpty())
                    @foreach ($friends as $friend)
                        <livewire:friend-list :friend="$friend" :key="$friend->id" />
                    @endforeach
                @else
                    <div class="empty-state">
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
