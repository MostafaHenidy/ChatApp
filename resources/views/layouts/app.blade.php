<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('front.partials.head')

<body>
    <div class="brutalist-app-layout">
        @yield('content')
        <livewire:notification />
        <livewire:group />
    </div>
    @include('front.partials.scripts')
</body>

</html>
