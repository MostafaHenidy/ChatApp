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
                <ul>
                    <li>
                        <a class="text-decoration-none" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#NotificationsModal">
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
    </div>

    <div class="sidebar-content">
        @livewire('search-friend')
        <div class="sidebar-section">
            <div class="section-header">
                <h4 class="section-title">Groups</h4>
                <livewire:group />
            </div>
            <div class="contacts-list">
                @php
                    $groups = Auth::user()
                        ->groups->merge(Auth::user()->memberGroups)
                        ->unique('id');
                @endphp
                @forelse($groups as $group)
                    <a class='text-decoration-none ms-3 {{ request()->routeIs('front.group') && request()->id == $group->id ? 'active' : '' }}'
                        href="{{ route('front.group', ['id' => $group->id]) }}">
                        <div class="user-info">
                            <img src="{{ getAvatar(strtoupper($group->name)) }}" alt="{{ $group->name }}"
                                class="user-avatar">
                            <div class="user-details">
                                <span class="user-name">{{ $group->name }}</span>
                                <span class="user-status">{{ $group->members->count() }} members</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <p>No groups yet</p>
                    </div>
                @endforelse
            </div>
        </div>
        <style>
            a.active .user-info {
                background-color: #e5edf5;
                border-radius: 10px;
                transition: 0.2s ease;
                padding: 5px;
            }

            a.active .user-name {
                font-weight: 600;
                color: #007bff;
            }
        </style>
</aside>
