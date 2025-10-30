<div class="brutalist-chat">
    <div class="brutalist-sidebar__user-link">
        <div class="brutalist-user-info" style="justify-content: space-between; width: 100%;">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <img class="brutalist-user-info__avatar" src="{{ getAvatar(strtoupper($this->group->name)) }}"
                    alt="{{ $this->group->slug }}">
                <div class="brutalist-user-info__details">
                    <h6 class="brutalist-user-info__name">{{ $this->group->name }}</h6>
                </div>
            </div>
            <a class="brutalist-btn brutalist-btn--sm"
                href="{{ route('front.groupManagement', ['id' => $this->group->id]) }}">
                <i class="bi bi-gear"></i>
            </a>
        </div>
    </div>
    <div class="brutalist-chat__messages" id="messagesContainer">
        <div class="messages-list" id="messagesList">
            @foreach ($messages as $message)
                <div class="brutalist-message {{ $message->user_id === auth()->id() ? 'brutalist-message--user' : '' }}"
                    data-message-id="{{ $message->id }}">
                    @if ($message->user_id !== auth()->id())
                        <img src="{{ getAvatar($message->user->name) }}" alt="{{ $message->user->name }}"
                            class="brutalist-user-info__avatar">
                    @endif
                    <div class="brutalist-message__content">
                        <div class="brutalist-message__bubble">
                            @if ($message->message)
                                <p>{{ $message->message }}</p>
                            @endif
                        </div>
                        <div class="brutalist-helper-text">
                            <span>{{ $message->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if (!$this->group->admin_only_post)
        <form id="messageForm" wire:submit ='sendMessage' class="message-form" enctype="multipart/form-data">
            <div class="brutalist-chat__input-area">
                <input type="text" wire:model ='body' name="message" id="messageInput" class="brutalist-chat__input"
                    placeholder="Type a message..." autocomplete="off">
                <button type="submit" class="brutalist-btn" id="sendButton">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                    </svg>
                    <div wire:loading class="brutalist-spinner" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </button>
            </div>
        </form>
    @else
        <div class="brutalist-helper-text">
            <p>Only admin can send message</p>
        </div>
    @endif
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
