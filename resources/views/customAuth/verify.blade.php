@extends('layouts.auth')

@section('subtitle', 'Verify your email address')

@section('content')
    @if (session('resent'))
        <div class="alert alert-success">
            A fresh verification link has been sent to your email address.
        </div>
    @endif

    <div class="auth-form">
        <p class="auth-text">
            Before proceeding, please check your email for a verification link.
            If you did not receive the email, you can request another one below.
        </p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-full">
                Resend verification email
            </button>
        </form>

        <div class="auth-links">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="auth-link btn-link">
                    Sign out
                </button>
            </form>
        </div>
    </div>
@endsection
