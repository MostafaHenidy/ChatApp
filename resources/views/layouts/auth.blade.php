<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Chat App') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/brutalist.css') }}">
</head>

<body>
    <div class="brutalist-container">
        <div class="brutalist-card">
            <div class="brutalist-card__header">
                <h1>{{ config('app.name', 'Chat App') }}</h1>
                <p class="auth-subtitle">@yield('subtitle')</p>
            </div>
            <div class="brutalist-card__body">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('front-assets/js/brutalist.js') }}"></script>
</body>

</html>
