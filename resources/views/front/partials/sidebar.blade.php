<aside class="sidebar">
    <div class="sidebar-header">
        <a class="text-decoration-none" href="{{ route('front.index') }}">
            <div class="user-info">
                <img src="{{ getAvatar(auth()->user()->name) }}" alt="{{ auth()->user()->name }}" class="user-avatar">
                <div class="user-details">
                    <h3 class="user-name">{{ auth()->user()->name }}</h3>
                    <span class="user-status online">Online</span>
                </div>
            </div>
        </a>
        <label class="popup">
            <input type="checkbox">
            <div class="burger" tabindex="0">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="popup-window">
                {{-- <legend>Actions</legend> --}}
                <ul>
                    <li>
                        <a class="text-decoration-none" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <button>
                            <i class="bi bi-bell"></i>
                            <span>Notifications</span>
                        </button>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form dropdown-item">
                            @csrf
                            <button>
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </label>
        {{-- <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profile<i class="bi bi-person-circle"></i></a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form dropdown-item">
                        @csrf
                        <button type="submit" class="btn-icon" title="Sign out">Logout
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div> --}}

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
