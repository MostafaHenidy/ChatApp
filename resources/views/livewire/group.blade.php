<div>
    <!-- Modal -->
    <div wire:ignore.self class="brutalist-modal-overlay" id="addGroupModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="brutalist-modal">
            <div class="brutalist-modal__header">
                <h1 class="modal-title fs-5"><i class="bi bi-people-fill me-2"></i>Create Group</h1>
                <button type="button" class="brutalist-btn brutalist-btn--sm brutalist-icon " data-modal-close=""
                    aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <form wire:submit.prevent="createGroup">
                <div class="brutalist-modal__body">
                    <div class="brutalist-form-group">
                        <label class="brutalist-label" for="name">Group Name</label>
                        <input class="brutalist-input" type="text" name="name" wire:model="name">
                    </div>
                    <div class="brutalist-sidebar__contacts-list">
                        @foreach ($this->friends as $friend)
                            <div class="brutalist-user-info brutalist-flex brutalist-flex--between">
                                <div class="brutalist-flex brutalist-flex--center">
                                    <img class="brutalist-user-info__avatar" src="{{ getAvatar($friend->name) }}"
                                        alt="{{ $friend->name }}">
                                    <div class="brutalist-user-info__details">
                                        <span class="brutalist-user-info__name">{{ $friend->name }}</span>
                                        <span
                                            class="brutalist-user-info__status brutalist-user-info__status--{{ $friend->is_online ? 'online' : 'offline' }}">
                                            {{ $friend->is_online ? 'online' : 'offline' }}
                                        </span>
                                    </div>
                                </div>
                                <button type="button" class="brutalist-btn brutalist-btn--icon"
                                    wire:click.stop="toggleFriend({{ $friend->id }})">
                                    @if (in_array($friend->id, $selectedFriends))
                                        <i class="bi bi-person-check-fill text-primary fs-5"></i>
                                    @else
                                        <i class="bi bi-person-plus-fill text-secondary fs-5"></i>
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="brutalist-modal__footer">
                    <button type="button" class="brutalist-btn brutalist-btn--secondary"
                        data-modal-close="">Cancel</button>
                    <button type="submit" class="brutalist-btn">Create</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.addEventListener('groupCreated', () => {
            const modalElement = document.getElementById('addGroupModal');
            modalElement.classList.remove('active');
        });
    </script>
</div>
