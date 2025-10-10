@extends('layouts.auth')

@section('subtitle', 'Reset your password')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" class="form-input @error('email') error @enderror" name="email"
                value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">New password</label>
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
            Reset password
        </button>
    </form>
@endsection
