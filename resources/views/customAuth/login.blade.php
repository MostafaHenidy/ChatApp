@extends('layouts.auth')

@section('subtitle', 'Sign in to your account')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" class="form-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-input @error('password') error @enderror" name="password"
                required autocomplete="current-password">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-checkbox">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark"></span>
                Remember me
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
            Sign in
        </button>

        <div class="auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">
                    Forgot your password?
                </a>
            @endif

            <p class="auth-text">
                Don't have an account?
                <a href="{{ route('register') }}" class="auth-link">Sign up</a>
            </p>
        </div>
    </form>
@endsection
