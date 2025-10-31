@extends('layouts.auth')

@section('subtitle', 'Reset Your Password ')

@section('content')
    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="brutalist-form-group">
            <label for="email" class="brutalist-form-label">Email address</label>
            <input id="email" type="email" class="brutalist-input @error('email') error @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="brutalist-form-group">
            <label class="brutalist-label" for="password">Password</label>
            <div class="input-group">
                <input type="password" name="password" class="brutalist-input" id="password"
                    placeholder="Enter your password">
                <button class="brutalist-btn--icon brutalist-btn toggle-password" type="button">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="brutalist-form-group">
            <label class="brutalist-label" for="password_confirmation">Confirmation your password</label>
            <div class="input-group">
                <input type="password_confirmation" name="password_confirmation" class="brutalist-input"
                    id="password_confirmation" placeholder="Confirm your password">
                <button class="brutalist-btn--icon brutalist-btn toggle-password" type="button">
                    <i class="bi bi-eye-slash"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="brutalist-form-actions">
            <button type="submit" class="brutalist-btn ">
                Reset Password
            </button>
        </div>

    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePasswordButtons = document.querySelectorAll(".toggle-password");

            togglePasswordButtons.forEach(button => {
                button.addEventListener("click", function() {
                    // This selector is more robust: it finds *any* input inside the same .input-group
                    const passwordInput = this.closest('.input-group').querySelector('input');
                    const icon = this.querySelector('i');

                    if (passwordInput) { // Check that we actually found an input
                        const type = passwordInput.getAttribute("type") === "password" ? "text" :
                            "password";
                        passwordInput.setAttribute("type", type);

                        icon.classList.toggle("bi-eye");
                        icon.classList.toggle("bi-eye-slash");
                    }
                });
            });
        });
    </script>
@endsection
