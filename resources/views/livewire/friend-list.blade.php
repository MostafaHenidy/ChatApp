<div>
    <a class="text-decoration-none {{ request()->routeIs('front.chat') && request()->id == $friend->id ? 'active' : '' }} "
        href="{{ route('front.chat', ['id' => $friend->id]) }}">
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
    <style>
        a.active .search-user-info {
            background-color: #e5edf5;
            border-radius: 10px;
            transition: 0.2s ease;
            padding: 5px;
        }

        a.active .contact-name {
            font-weight: 600;
            color: #007bff;
        }
    </style>
</div>
