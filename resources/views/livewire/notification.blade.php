<div>
    <!--Notification Modal -->
    <div class="modal fade" wire:ignore.self id="NotificationsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <h1 class="modal-title fs-5 fw-bold d-flex align-items-center" id="NotificationsModalLabel">
                        <i class="bi bi-bell-fill me-2 "></i>Notifications
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x fs-2"></i></button>
                </div>
                <hr>
                <div class="modal-body">
                    @forelse($this->notifications as $notify)
                        <div class="notification-list-container">
                            <div class="notification-item {{ $notify->read_at ? 'read' : 'unread' }}">
                                <div class="notification-left">
                                    <strong class="notification-sender">{{ $notify->data['sender_name'] }}</strong>
                                    <p class="notification-message mb-0">
                                        sent you a message: "{{ $notify->data['message'] }}"
                                    </p>
                                </div>

                                <div class="notification-right">
                                    <small class="notification-time">
                                        {{ $notify->created_at->diffForHumans() }}
                                    </small>
                                    <div class="notification-item-controls">
                                        @if (!$notify->read_at)
                                            <button class="btn-control btn-accept"
                                                wire:click="markAsRead('{{ $notify->id }}')" title="Mark as read">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif
                                        <button class="btn-control btn-decline"
                                            wire:click="deleteNotification('{{ $notify->id }}')"
                                            title="Remove notification">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">No new notifications</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="readAll">Read All</button>
                    <button class="btn btn-primary" wire:click="deleteAll">Delete All</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', () => {
        if (!window.pusher) {
            window.pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
                cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                authEndpoint: "/broadcasting/auth",
                auth: {
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }
            });
        }

        const userChannel = window.pusher.subscribe(`private-App.Models.User.{{ auth()->id() }}`);

        userChannel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
            console.log("🔔 New notification:", data);
            Livewire.dispatch('refreshNotifications');
        });
    });
</script>
