<div class="brutalist-sidebar__user-link">
    <div class="brutalist-user-info">
        <img class="brutalist-user-info__avatar" src="{{ getAvatar(strtoupper($user->name)) }}" alt="{{ $user->name }}">
        <div class="brutalist-user-info__details">
            <h6 class="brutalist-user-info__name">
                {{ $user->name }}
            </h6>
            <span
                class="brutalist-user-info__status brutalist-user-info__status--{{ $user->is_online ? 'online' : 'offline' }}">{{ $user->is_online ? 'Online' : 'Offline' }}</span>
        </div>
    </div>
</div>
