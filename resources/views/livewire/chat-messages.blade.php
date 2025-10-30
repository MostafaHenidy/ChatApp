<div class="brutalist-chat">
    <livewire:user-info :user="$friend" />
    <div class="brutalist-chat__messages" id="messagesContainer">
        <div id="messagesList">
            @foreach ($messages as $message)
                <div class="brutalist-message {{ $message->sender_id === auth()->id() ? 'brutalist-message--user' : '' }}"
                    data-message-id="{{ $message->id }}">
                    @if ($message->sender_id !== auth()->id())
                        <img src="{{ getAvatar($message->sender->name) }}" alt="{{ $message->sender->name }}"
                            class="brutalist-user-info__avatar">
                    @endif
                    <div class="brutalist-message__content">
                        <div class="brutalist-message__bubble">
                            @if ($message->body)
                                {{ $message->body }}
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
    <form id="messageForm" wire:submit="sendMessage" enctype="multipart/form-data">
        <div class="brutalist-chat__input-area">
            <input type="text" wire:model="body" name="body" id="messageInput" placeholder="Type a message..."
                autocomplete="off" class="brutalist-chat__input">
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
