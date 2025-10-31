@extends('layouts.auth')

@section('subtitle', 'Forgot Password')

@section('content')
    <div style="margin-bottom: var(--spacing-2xl); text-align: center;">
        <h4>
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link
            that will allow you to choose a new one.
        </h4>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf
        <div class="brutalist-form-group">
            <label for="email" class="brutalist-form-label">Email address</label>
            <input id="email" type="email" class="brutalist-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="brutalist-form-actions">
            <button type="submit" class="brutalist-btn brutalist-btn--primary">
                Email Password Reset Link
            </button>
        </div>
    </form>
@endsection
