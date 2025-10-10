@extends('layouts.auth')

@section('subtitle', 'Create your account')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Full name</label>
            <input id="name" type="text" class="form-input @error('name') error @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" class="form-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-input @error('password') error @enderror" name="password"
                required autocomplete="new-password">
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm" class="form-label">Confirm password</label>
            <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required
                autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary btn-full">
            Create account
        </button>

        <div class="auth-links">
            <p class="auth-text">
                Already have an account?
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            </p>
        </div>
    </form>
@endsection
