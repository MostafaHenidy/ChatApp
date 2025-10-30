@extends('layouts.auth')

@section('subtitle', 'Create your account')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="brutalist-form-group">
            <label for="name" class="brutalist-label">Full name</label>
            <input id="name" type="text" class="brutalist-input @error('name') error @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="brutalist-form-group">
            <label for="email" class="brutalist-label">Email address</label>
            <input id="email" type="email" class="brutalist-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="brutalist-form-group">
            <label for="password" class="brutalist-label">Password</label>
            <input id="password" type="password" class="brutalist-input @error('password') error @enderror" name="password"
                required autocomplete="new-password">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="brutalist-form-group">
            <label for="password-confirm" class="brutalist-label">Confirm password</label>
            <input id="password-confirm" type="password" class="brutalist-input" name="password_confirmation" required
                autocomplete="new-password">
        </div>

        <button type="submit" class="brutalist-btn">
            Create account
        </button>
        <div class="brutalist-form-footer">
            <p class="auth-text">
                Already have an account?
                <a href="{{ route('login') }}" class="brutalist-link">Sign in</a>
            </p>
        </div>
    </form>
@endsection
