<div>
    <main class="main-content">
        <livewire:user-info :user="$friend" />
        <div class="messages-container" id="messagesContainer">
            <div class="messages-list" id="messagesList">
                @foreach ($messages as $message)
                    <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}"
                        data-message-id="{{ $message->id }}">
                        @if ($message->sender_id !== auth()->id())
                            <img src="{{ getAvatar($message->sender->name) }}" alt="{{ $message->sender->name }}"
                                class="message-avatar">
                        @endif
                        <div class="message-content">
                            <div class="message-bubble">
                                @if ($message->body)
                                    <p class="message-text">{{ $message->body }}</p>
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

        <div class="typing-indicator" id="typingIndicator" style="display: none;">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="typing-text">Someone is typing...</span>
        </div>
        <div class="message-input-container">
            <form id="messageForm" wire:submit ='sendMessage' class="message-form" enctype="multipart/form-data">
                <div class="message-input">
                    <input type="text" wire:model ='body' name="body" id="messageInput"
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
<script>
    var conversationId = "{{ $this->conversation->id }}";
    console.log("Subscribing to private-chat." + conversationId);
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('1e3de166ddf77ccc701a', {
        cluster: 'eu',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });
    var privateChannel = pusher.subscribe(`private-chat.${conversationId}`);
    privateChannel.bind('UserSendMessage', function(data) {
        console.log('Pusher event received:', data);
        Livewire.dispatch('userSendMessage', {
            messageData: data.message
        });
    });
</script>
