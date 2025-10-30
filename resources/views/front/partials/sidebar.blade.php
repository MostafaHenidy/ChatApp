<button class="brutalist-mobile-toggle" id="mobile-sidebar-toggle" aria-label="Open menu">
    <span></span>
    <span></span>
    <span></span>
</button>
<aside class="brutalist-sidebar">
    <div class="brutalist-sidebar__header">
        <a class="brutalist-sidebar__user-link" href="{{ route('front.index') }}">
            <div class="brutalist-user-info">
                <img src="{{ getAvatar(auth()->user()->name) }}" alt="{{ auth()->user()->name }}"
                    class="brutalist-user-info__avatar">
                <div class="brutalist-user-info__details">
                    <h3 class="brutalist-user-info__name">{{ auth()->user()->name }}</h3>
                    @if (auth()->user()->is_online)
                        <span class="brutalist-user-info__status brutalist-user-info__status--online">Online</span>
                    @else
                        <span class="brutalist-user-info__status brutalist-user-info__status--offline">Offline</span>
                    @endif
                </div>
            </div>
        </a>
        <label class="brutalist-menu-toggle" title="Toggle menu">
            <input type="checkbox" class="brutalist-menu-toggle__input" aria-label="Toggle menu">
            <!-- Made toggle button more prominent with larger size, visible label, and better styling -->
            <div class="brutalist-menu-toggle__burger" tabindex="0" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </div> <span class="brutalist-menu-toggle__label">MENU</span>
            <nav class="brutalist-menu-toggle__menu">
                <ul class="brutalist-menu-toggle__list">
                    <li>
                        <a class="brutalist-menu-toggle__link" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <button type="button" class="brutalist-menu-toggle__link" data-bs-toggle="modal"
                            data-bs-target="#NotificationsModal">
                            <i class="bi bi-bell"></i>
                            <span>Notifications</span>
                        </button>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="brutalist-menu-toggle__form">
                            @csrf
                            <button class="brutalist-menu-toggle__link">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </label>
    </div>
    <div class="brutalist-sidebar__content">
        @livewire('search-friend')
        <div class="brutalist-sidebar__section">
            <div class="brutalist-sidebar__section-header">
                <h4 class="brutalist-sidebar__section-title">Groups</h4>
                <button class="brutalist-btn brutalist-btn--icon" data-modal-trigger="addGroupModal">
                    <i class="bi bi-plus-circle-fill"></i>
                </button>
            </div>
            <div class="brutalist-sidebar__contacts-list">
                @php
                    $groups = Auth::user()
                        ->groups->merge(Auth::user()->memberGroups)
                        ->unique('id');
                @endphp
                @forelse($groups as $group)
                    <a class="brutalist-sidebar__group-link {{ request()->routeIs('front.group') && request()->id == $group->id ? 'brutalist-sidebar__group-link--active' : '' }}"
                        href="{{ route('front.group', ['id' => $group->id]) }}">
                        <div class="brutalist-user-info">
                            <img src="{{ getAvatar(strtoupper($group->name)) }}" alt="{{ $group->name }}"
                                class="brutalist-user-info__avatar">
                            <div class="brutalist-user-info__details">
                                <span class="brutalist-user-info__name">{{ $group->name }}</span>
                                <span class="brutalist-user-info__status">{{ $group->members->count() }} members</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="brutalist-empty-state">
                        <p>No groups yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</aside>
