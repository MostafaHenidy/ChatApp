<div>
    <!--Notification Modal -->
    <div wire:ignore.self class="brutalist-modal-overlay" id="NotificationsModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="brutalist-modal">
            <div class="brutalist-modal__header">
                <h1 class="modal-title fs-5" id="NotificationsModalLabel">
                    <i class="bi bi-bell-fill me-2 "></i>Notifications
                </h1>
                <button type="button" class="brutalist-btn brutalist-btn--sm brutalist-btn--icon "
                    data-modal-close=""><i class="bi bi-x fs-2"></i></button>
            </div>
            <div class="brutalist-modal__body">
                <div class="brutalist-notification-list">
                    @forelse($this->notifications as $notify)
                        <div class="brutalist-notification-item {{ $notify->read_at ? 'read' : 'unread' }}">
                            <div class="brutalist-notification-icon">
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                            <div class="brutalist-notification-content">
                                <p class="brutalist-notification-text">
                                    <strong>{{ $notify->data['sender_name'] }}</strong>
                                    sent you a message: "{{ $notify->data['message'] }}"
                                </p>
                                <small class="brutalist-notification-time">
                                    {{ $notify->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="notification-item-controls">
                                @if (!$notify->read_at)
                                    <button
                                        class="brutalist-btn brutalist-btn--secondary brutalist-btn--sm brutalist-btn--icon"
                                        wire:click="markAsRead('{{ $notify->id }}')" title="Mark as read">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                @endif
                                <button
                                    class="brutalist-btn brutalist-btn--accent brutalist-btn--sm brutalist-btn--icon"
                                    wire:click="deleteNotification('{{ $notify->id }}')" title="Remove notification">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="brutalist-empty-state">
                            <p>No new notifications</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="brutalist-modal__footer">
                <button class="brutalist-btn brutalist-btn--secondary" wire:click="readAll">Read All</button>
                <button class="brutalist-btn" wire:click="deleteAll">Delete All</button>
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
