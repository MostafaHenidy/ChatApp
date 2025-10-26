<div>
    <main class="main-content">
        <div class="chat-header group">
            <div class="left-section">
                <div class="group-info">
                    <img src="{{ getAvatar(strtoupper($this->group->slug)) }}" alt="{{ $this->group->slug }}">
                    <div class="group-text">
                        <h2 class="chat-name">{{ $this->group->name }}</h2>
                        <div class="group-members">
                            @if (count($this->group->members) > 3)
                                @foreach ($this->group->members->take(3) as $member)
                                    <div class="member">
                                        <img class="group-avatar" src="{{ getAvatar($member->name) }}"
                                            alt="{{ $member->name }}">
                                        <h6 class="group-name">
                                            @if ($member->id != auth()->user()->id)
                                                {{ $member->name }}
                                            @else
                                                <span>You</span>
                                            @endif
                                        </h6>
                                        @if ($member->is_online)
                                            <span class="group-status online">
                                                <span class="status-dot online"></span> Online
                                            </span>
                                        @else
                                            <span class="group-status offline">
                                                <span class="status-dot offline"></span> Offline
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                                <p class="text-muted mt-3">
                                    and {{ count($this->group->members) - 3 }} more
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-section">
                <label class="popup">
                    <input type="checkbox">
                    <div class="burger" tabindex="0">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <nav class="popup-window">
                        <ul>
                            <li>
                                <a class="text-decoration-none"
                                    href="{{ route('front.groupManagement', ['id' => $this->group->id]) }}">
                                    <i class="bi bi-people-fill"></i>
                                    <span>Members</span>
                                </a>
                            </li>
                            <li>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#NotificationsModal">
                                    <i class="bi bi-bell"></i>
                                    <span>Add Member</span>
                                </button>
                            </li>
                            <li>
                                <button>
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>kick Member</span>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </label>
            </div>
        </div>
        <div class="messages-container" id="messagesContainer">
            <div class="messages-list" id="messagesList">
                @foreach ($messages as $message)
                    <div class="message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}"
                        data-message-id="{{ $message->id }}">
                        @if ($message->user_id !== auth()->id())
                            <img src="{{ getAvatar($message->user->name) }}" alt="{{ $message->user->name }}"
                                class="message-avatar">
                        @endif
                        <div class="message-content">
                            <div class="message-bubble">
                                @if ($message->message)
                                    <p class="message-text">{{ $message->message }}</p>
                                @endif
                            </div>
                            <div class="message-meta">
                                <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="message-input-container">
            <form id="messageForm" wire:submit ='sendMessage' class="message-form" enctype="multipart/form-data">
                <div class="message-input">
                    <input type="text" wire:model ='body' name="message" id="messageInput"
                        placeholder="Type a message..." autocomplete="off">
                </div>

                <button type="submit" class="btn-send" id="sendButton">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                    </svg>
                    <div wire:loading class="spinner-border text-primary" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </button>
            </form>
        </div>
    </main>
</div>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>

<script>
    const groupId = "{{ $this->group->id }}";
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '1e3de166ddf77ccc701a',
        cluster: 'eu',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });
    window.Echo.join(`presence-chat.${groupId}`)
        .here((users) => {
            console.log('Members present:', users);
        })
        .joining((user) => {
            console.log('Member joined:', user);
        })
        .leaving((user) => {
            console.log('Member left:', user);
        })
        .listen('.UserSendGroupMessage', (e) => {
            console.log('Custom event received:', e);
            Livewire.dispatch('userSendGroupMessage', e);
        });
</script>
