@extends('layouts.auth')

@section('subtitle', 'Reset your password')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" class="form-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-full">
            Send password reset link
        </button>

        <div class="auth-links">
            <p class="auth-text">
                Remember your password?
                <a href="{{ route('login') }}" class="auth-link">Sign in</a>
            </p>
        </div>
    </form>
@endsection
