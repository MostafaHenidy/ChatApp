<div>
    <a class="text-decoration-none" href="{{ route('front.chat', ['id' => $friend->id]) }}">
        <div class="search-user-info ms-3">
            <div class="contact-avatar">
                <img src="{{ getAvatar($friend->name) }}" alt="{{ $friend->name }}">
                <span class="status-indicator {{ $friend->is_online ? 'online' : 'offline' }}"></span>
            </div>
            <div class="contact-info">
                <span class="contact-name">{{ $friend->name }}</span>
                <span class="contact-status">
                    {{ $friend->is_online ? 'online' : 'offline' }}
                </span>
            </div>
        </div>
    </a>
</div>
