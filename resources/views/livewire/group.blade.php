<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn add-group-btn" data-bs-toggle="modal" data-bs-target="#addGroupModal">
        <i class="bi bi-plus-circle-fill"></i>
    </button>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="bi bi-people-fill me-2"></i>
                        Create Group
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="createGroup">
                    <div class="modal-body">
                        <label class="form-label mb-2" for="name">Group Name</label>
                        <input class="form-control" type="text" name="name" wire:model="name">

                        @foreach ($this->friends as $friend)
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="contact-avatar me-2">
                                        <img src="{{ getAvatar($friend->name) }}" alt="{{ $friend->name }}">
                                        <span
                                            class="status-indicator {{ $friend->is_online ? 'online' : 'offline' }}"></span>
                                    </div>
                                    <div class="contact-info">
                                        <span class="contact-name d-block">{{ $friend->name }}</span>
                                        <span class="contact-status text-muted small">
                                            {{ $friend->is_online ? 'online' : 'offline' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Icon button acts as checkbox -->
                                <button type="button" class="btn border-0 bg-transparent p-0"
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('groupCreated', () => {
            const modalElement = document.getElementById('addGroupModal');
            const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);

            // Properly hide the modal
            modal.hide();

            // Manually remove the backdrop if it remains
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            // Re-enable body scrolling and interaction
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        });
    </script>
</div>
