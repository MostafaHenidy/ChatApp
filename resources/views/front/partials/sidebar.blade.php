<aside class="sidebar">
    <div class="sidebar-header">
        <div class="user-info">
            <img src="{{ getAvatar(auth()->user()->name) }}" alt="{{ auth()->user()->name }}" class="user-avatar">
            <div class="user-details">
                <h3 class="user-name">{{ auth()->user()->name }}</h3>
                <span class="user-status online">Online</span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn-icon" title="Sign out">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16,17 21,12 16,7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </button>
        </form>
    </div>

    <div class="sidebar-content">
        @livewire('search-friend')     
        <div class="sidebar-section">
            <div class="section-header">
                <h4 class="section-title">Groups</h4>
                {{-- <a href="{{ route('groups.create') }}" class="btn-icon" title="Create group">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </a> --}}
            </div>
            <div class="contacts-list">
                {{-- @forelse($groups as $group)
                            <a href="{{ route('chat', ['type' => 'group', 'id' => $group->id]) }}"
                                class="contact-item {{ $chatData['type'] === 'group' && $chatData['id'] == $group->id ? 'active' : '' }}">
                                <div class="contact-avatar">
                                    <img src="{{ $group->avatar_url }}" alt="{{ $group->name }}">
                                </div>
                                <div class="contact-info">
                                    <span class="contact-name">{{ $group->name }}</span>
                                    <span class="contact-status">{{ $group->members->count() }} members</span>
                                </div>
                            </a>
                        @empty
                            <div class="empty-state">
                                <p>No groups yet</p>
                            </div>
                        @endforelse --}}
            </div>
        </div>
    </div>
</aside>
