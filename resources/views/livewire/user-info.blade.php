<div class="user-info">
    <img src="{{ getAvatar($user->name) }}" alt="{{ $user->name }}" class="user-avatar">
    <div class="user-details">
        <h3 class="user-name">{{ $user->name }}</h3>

        @if ($updateOnlineStatus)
            <span class="user-status online">Online</span>
        @else
            <span class="user-status offline">
                Offline</span>
        @endif
    </div>
</div>
