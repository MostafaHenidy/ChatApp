<div class="chat-header friend">
    <div class="avatar-wrapper position-relative">
        <img class="group-avatar" src="{{ getAvatar(strtoupper($user->name)) }}" alt="{{ $user->name }}">
        <span class="status-dot {{ $user->is_online ? 'online' : 'offline' }}"></span>
    </div>
    <div>
        <h6 class="group-name">
            {{ $user->name }}
        </h6>
        <span
            class="user-status {{ $user->is_online ? 'online' : 'offline' }}">{{ $user->is_online ? 'Online' : 'Offline' }}</span>
    </div>
</div>
