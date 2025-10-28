<div>
    <main class="main-content">
        <div class="chat-header group">
            <div class="left-section">
                <div class="group-info">
                    <img class="group-avatar" src="{{ getAvatar(strtoupper($this->group->name)) }}"
                        alt="{{ $this->group->slug }}">
                    <div class="group-text">
                        <h2 class="chat-name mt-2">{{ $this->group->name }}</h2>
                    </div>
                </div>
            </div>
            <a class="text-decoration-none text-dark return-home"
                href="{{ route('front.groupManagement', ['id' => $this->group->id]) }}">
                <i class="bi bi-gear"></i>
            </a>
        </div>
        <div class="messages-container" id="messagesContainer">
            <div class="messages-list" id="messagesList">
                @foreach ($messages as $message)
                    <div class="message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}"
                        data-message-id="{{ $message->id }}">
                        @if ($message->user_id !== auth()->id())
                            <img src="{{ getAvatar($message->user->name) }}" alt="{{ $message->user->name }}"
                                class="message-avatar mt-2">
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
        @if (!$this->group->admin_only_post)
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
        @else
            <div class="d-flex justify-content-center mb-3">
                <p class="text-muted">Only admin can send message</p>
            </div>
        @endif
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
