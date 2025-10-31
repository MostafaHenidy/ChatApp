@extends('layouts.app')

@section('content')
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <div class="brutalist-main-content">
        <a href="{{ route('front.index') }}" class="brutalist-btn--icon brutalist-btn--sm brutalist-mb">
            <i class="bi bi-arrow-left-short fs-3"></i>
        </a>
        <!-- Profile Header -->
        <div class="brutalist-sidebar__user-link brutalist-mb">
            <div class="brutalist-user-info">
                <div class="brutalist-avatar--lg">
                    <img class="avatar" id="avatarPreview" src="{{ getAvatar(auth()->user()->name) }}"
                        alt="{{ auth()->user()->name }}">
                </div>
                <div class="brutalist-user-info__details">
                    <h1>{{ Auth::user()->name }}</h1>
                    @if (Auth::user()->email_verified_at == null)
                        <div>
                            <span class="">{{ Auth::user()->email }}</span>
                            <i class="bi bi-patch-exclamation-fill text-warning"></i>
                        </div>
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" type="submit"
                                    class="brutalist-btn--icon brutalist-btn--sm" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Click here to verify your email address">
                                    <i class="bi bi-patch-check-fill"></i>
                                </button>
                            </p>
                        </div>
                    @else
                        <div>
                            <span>{{ Auth::user()->email }}</span>
                            <i class="bi bi-patch-check-fill text-primary"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs brutalist-mb">
            <button class="brutalist-navbar__link" onclick="switchTab('profile')">Edit Profile</button>
            <button class="brutalist-navbar__link" onclick="switchTab('password')">Update Password</button>
            <button class="brutalist-navbar__link" onclick="switchTab('delete')">Delete Account</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Edit Profile Tab -->
            <div id="profile" class="tab-pane active">
                <h2 class="brutalist-mb">Edit Your Profile</h2>
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="brutalist-form-group">
                        <label class="brutalist-label" for="name">Full Name</label>
                        <input class="brutalist-input" type="text" id="name" name="name"
                            value="{{ auth()->user()->name }}" placeholder="Enter your full name">
                        <x-input-error class="brutalist-input--error" :messages="$errors->get('name')" />
                    </div>
                    <div class="brutalist-form-group">
                        <label class="brutalist-label" for="email">Email Address</label>
                        <input class="brutalist-input" type="email" name="email" id="email"
                            value="{{ auth()->user()->email }}" placeholder="Enter your email">
                        <x-input-error class="brutalist-input--error" :messages="$errors->get('email')" />
                    </div>
                    <div class="brutalist-form-group">
                        <label class="brutalist-label" for="phone">phone</label>
                        <input class="brutalist-input " name="phone"id="phone" value="{{ auth()->user()->phone }}"
                            placeholder="+201234567890">
                        <x-input-error class="brutalist-input--error" :messages="$errors->get('phone')" />
                    </div>
                    <div class="brutalist-file-upload">

                        <label class="brutalist-file-upload__label" for="avatar">
                            <div class="brutalist-file-upload__text">Drag files here or click to upload</div>
                            <div class="brutalist-file-upload__hint">Supported formats: JPG, PNG, PDF (Max 10MB)</div>
                        </label>
                        <input type="file" name="avatar" id="avatar" class="brutalist-file-upload__input"
                            accept="image/*">
                        <x-input-error class="brutalist-input--error" :messages="$errors->get('avatar')" />
                    </div>
                    <div class="brutalist-form-actions">
                        <button type="cancel" class="brutalist-btn brutalist-btn--secondary">Cancel</button>
                        <button type="submit" class="brutalist-btn">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Update Password Tab -->
            <div id="password" class="tab-pane">
                <h2 class="brutalist-mb">Update Password</h2>
                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')
                    <div class="brutalist-form-group">
                        <label class="brutalist-label" for="current_password">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="brutalist-input" id="current_password"
                                placeholder="Enter current password">
                            <button class="brutalist-btn--icon brutalist-btn toggle-password" type="button">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                    <div class="brutalist-form-group">
                        <label class="brutalist-label mt-2" for="password">New Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="brutalist-input" id="new_password"
                                placeholder="Enter new password">
                            <button class="brutalist-btn--icon brutalist-btn toggle-password" type="button">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div class="brutalist-form-group">
                        <label class="brutalist-label mt-2" for="password_confirmation">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" class="brutalist-input password-input"
                                id="password_confirmation" placeholder="Confirm new password">
                            <button class="brutalist-btn--icon brutalist-btn toggle-password" type="button">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="brutalist-form-actions">
                        <button type="submit" class="brutalist-btn brutalist-btn--secondary">Cancel</button>
                        <button type="cancel" class="brutalist-btn">Update Password</button>
                    </div>
                </form>
            </div>

            <!-- Delete Account Tab -->
            <div id="delete" class="tab-pane">
                <div class="delete-section">
                    <div class="brutalist-alert brutalist-alert--danger">
                        <i class="bi bi-x-square-fill brutalist-alert__icon"></i>
                        <div class="brutalist-alert__content">
                            <h2 class="brutalist-alert__title">Delete Your Account !</h2>
                            <p class="brutalist-alert__message">Once your account is deleted, all of its resources and data
                                will be permanently deleted. </p>
                        </div>
                    </div>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                        <div class="brutalist-form-group">
                            <label class="brutalist-label mt-2" for="confirm-delete">Type your password to confirm</label>
                            <div class="input-group">
                                <input type="password" name="password" class="brutalist-input password-input"
                                    id="password" placeholder="Enter new password">
                                <button class="brutalist-btn--icon brutalist-btn toggle-password" type="button">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                        <div class="brutalist-form-actions">
                            <button type="cancel" class="brutalist-btn brutalist-btn--secondary">Cancel</button>
                            <button type="submit" class="brutalist-btn brutalist-btn--accent">Delete
                                Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple tab switching with vanilla JS
        function switchTab(tabName) {
            // Hide all tab panes
            const tabPanes = document.querySelectorAll('.tab-pane');
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Remove active class from all nav tabs
            // FIX 2: Corrected selector from '.nav-tab' to '.brutalist-navbar__link'
            const navTabs = document.querySelectorAll('.brutalist-navbar__link');
            navTabs.forEach(tab => tab.classList.remove('active'));

            // Show selected tab pane
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked nav tab
            event.target.classList.add('active');
        }

        // Preview selected image (works for the same input)
        document.getElementById('avatar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        // Tooltip script (unchanged, looks correct)
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script>
        // Password toggle script
        document.addEventListener("DOMContentLoaded", function() {
            const togglePasswordButtons = document.querySelectorAll(".toggle-password");

            togglePasswordButtons.forEach(button => {
                button.addEventListener("click", function() {

                    // FIX 5: Corrected selector from '.brutalist-input-group' to '.input-group'
                    // to match the HTML structure.
                    const passwordInput = this.closest('.input-group').querySelector(
                        'input');
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
