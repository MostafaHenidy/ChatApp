<div>
    <!--Notification Modal -->
    <div class="modal fade" id="NotificationsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-bell-fill me-2"></i>Notifications
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @forelse($this->notifications as $notify)
                        <div class="alert alert-info mb-2">
                            <strong>{{ $notify->data['sender_name'] }}</strong> sent you a message:
                            <p>{{ $notify->data['message'] }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No new notifications</p>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    Pusher.logToConsole = true;

    const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
        cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
        authEndpoint: "/broadcasting/auth",
        auth: {
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        }
    });

    const channel = pusher.subscribe(`private-App.Models.User.{{ auth()->id() }}`);

    channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
        console.log("🔔 New notification:", data);
        Livewire.dispatch('refreshNotifications');
    });
</script>
