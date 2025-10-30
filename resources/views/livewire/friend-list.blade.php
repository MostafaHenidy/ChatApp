<div class="mt-3">
    <a class="brutalist-sidebar__user-link {{ request()->routeIs('front.chat') && request()->id == $friend->id ? 'brutalist-sidebar__user-link--active' : '' }} "
        href="{{ route('front.chat', ['id' => $friend->id]) }}">
        <div class="brutalist-user-info">
            <img class="brutalist-user-info__avatar" src="{{ getAvatar($friend->name) }}" alt="{{ $friend->name }}">
            <div class="brutalist-user-info__details">
                <span class="brutalist-user-info__name">{{ $friend->name }}</span>
                <span
                    class="brutalist-user-info__status brutalist-user-info__status--{{ $friend->is_online ? 'online' : 'offline' }}">{{ $friend->is_online ? 'Online' : 'Offline' }}</span>
            </div>
        </div>
    </a>
</div>
