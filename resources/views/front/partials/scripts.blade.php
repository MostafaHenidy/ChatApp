<script src="{{ asset('front-assets/js/brutalist.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
@livewireScripts
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher('1e3de166ddf77ccc701a', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('UserStatus');
    channel.bind('UserUpdateStatus', function(data) {
        console.log("userUpdateStatus event received, dispatching Livewire event:", JSON.stringify(data));
        Livewire.dispatch('userStatusUpdated');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
</script>
