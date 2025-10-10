<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Chat App') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-assets/css/app.css') }}">
</head>

<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">{{ config('app.name', 'Chat App') }}</h1>
                <p class="auth-subtitle">@yield('subtitle')</p>
            </div>
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('front-assets/js/app.js') }}"></script>
</body>

</html>
