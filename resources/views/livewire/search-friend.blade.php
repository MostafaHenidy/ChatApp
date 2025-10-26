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
        </div>
        <div class="contacts-list">
            @if (count($this->friends) > 0)
                @foreach ($this->friends as $friend)
                    <livewire:friend-list :friend="$friend" />
                @endforeach
            @else
                <div class="empty-state">
                    <p>there is no friends</p>
                </div>
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
</div>
