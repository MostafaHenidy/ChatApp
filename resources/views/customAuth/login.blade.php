@extends('layouts.auth')

@section('subtitle', 'Sign in to your account')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="brutalist-form-group">
            <label for="email" class="brutalist-form-label">Email address</label>
            <input id="email" type="email" class="brutalist-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="brutalist-form-group">
            <label for="password" class="brutalist-label">Password</label>
            <input id="password" type="password" class="brutalist-input @error('password') error @enderror" name="password"
                required autocomplete="current-password">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="brutalist-form-group">
            <label class="brutalist-checkbox">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="checkmark"></span>
                Remember me
            </label>
        </div>


        <div class="brutalist-form-actions">
            <button type="submit" class="brutalist-btn brutalist-btn--primary">
                Sign in
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="brutalist-link">
                    Forgot your password?
                </a>
            @endif
        </div>

        <div class="brutalist-form-footer">
            <p>Don't have an account?
                <a href="{{ route('register') }}" class="brutalist-link">Sign up</a>
            </p>
        </div>
    </form>
    </form>
@endsection
