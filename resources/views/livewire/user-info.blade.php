<div class="chat-header">
    <img src="{{ getAvatar($user->name) }}" alt="{{ $user->name }}" class="chat-avatar">
    <div class="chat-details">
        <h3 class="chat-name">{{ $user->name }}</h3>
        @if ($user->is_online)
            <span class="chat-status online">
                <span class="status-dot online"></span> Online
            </span>
        @else
            <span class="chat-status offline">
                <span class="status-dot offline"></span> Offline
            </span>
        @endif
    </div>
</div>
