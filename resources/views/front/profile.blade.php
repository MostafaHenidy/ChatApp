@extends('layouts.app')

@section('content')
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="avatar-wrapper position-relative d-inline-block">
                <img class="avatar" id="avatarPreview" src="{{ getAvatar(auth()->user()->name) }}"
                    alt="{{ auth()->user()->name }}">
                <!-- Hidden File Input -->
                <input type="file" id="avatarUpload" name="avatar" class="d-none" accept="image/*">
                <!-- Camera Button -->
                <button type="button" class="camera-btn" title="Change profile picture" id="changeAvatarBtn">
                    <i class="bi bi-camera-fill"></i>
                </button>
            </div>
            <div class="profile-info mt-3">
                <h1>{{ Auth::user()->name }}</h1>
                @if (Auth::user()->email_verified_at == null)
                    <div>
                        <span>{{ Auth::user()->email }}</span>
                        <i class="bi bi-patch-exclamation-fill text-warning"></i>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" type="button" class="btn btn-outline-primary btn-sm ms-2"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Click here to verify your email address">
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

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="switchTab('profile')">Edit Profile</button>
            <button class="nav-tab" onclick="switchTab('password')">Update Password</button>
            <button class="nav-tab" onclick="switchTab('delete')">Delete Account</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Edit Profile Tab -->
            <div id="profile" class="tab-pane active">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">Edit Your Profile</h2>
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label class="form-label mt-2" for="name">Full Name</label>
                        <input class="form-control" type="text" id="name" name="name"
                            value="{{ auth()->user()->name }}" placeholder="Enter your full name">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-2" for="email">Email Address</label>
                        <input class="form-control" type="email" name="email" id="email"
                            value="{{ auth()->user()->email }}" placeholder="Enter your email">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-2" for="phone">phone</label>
                        <input class="form-control " name="phone"id="phone" value="{{ auth()->user()->phone }}"
                            placeholder="+201234567890">
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                    <div class="form-group mt-3">
                        <label for="avatar">Profile Picture</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                    </div>
                    <div class="form-actions">
                        <button type="cancel" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Update Password Tab -->
            <div id="password" class="tab-pane">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">Update Password</h2>
                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label class="form-label mt-2" for="current_password">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control password-input"
                                id="current_password" placeholder="Enter current password">
                            <button class="input-group-text toggle-password" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-2" for="password">New Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control password-input" id="password"
                                placeholder="Enter new password">
                            <button class="input-group-text toggle-password" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

                    </div>
                    <div class="form-group">
                        <label class="form-label mt-2" for="password_confirmation">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" class="form-control password-input"
                                id="password_confirmation" placeholder="Confirm new password">
                            <button class="input-group-text toggle-password" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-secondary">Cancel</button>
                        <button type="cancel" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>

            <!-- Delete Account Tab -->
            <div id="delete" class="tab-pane">
                <div class="delete-section">
                    <div class="bg-danger">
                        <h3>Delete Your Account !</h3>
                        <p>Once your account is deleted, all of its resources and data will be permanently deleted. </p>
                    </div>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                        <div class="form-group">
                            <label class="form-label mt-2" for="confirm-delete">Type your password to confirm</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control password-input"
                                    id="password" placeholder="Enter new password">
                                <button class="input-group-text toggle-password" type="button" id="togglePassword">
                                    <i class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                        <div class="form-actions">
                            <button type="cancel" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete
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
            const navTabs = document.querySelectorAll('.nav-tab');
            navTabs.forEach(tab => tab.classList.remove('active'));

            // Show selected tab pane
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked nav tab
            event.target.classList.add('active');
        }
        // Handle camera button click → open file dialog
        document.getElementById('changeAvatarBtn').addEventListener('click', function() {
            document.getElementById('avatar').click();
        });

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
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastLiveExample = document.getElementById('liveToast')

            if (toastTrigger) {
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                toastTrigger.addEventListener('click', () => {
                    toastBootstrap.show();
                    setTimeout(() => {
                        toastBootstrap.hide();
                    }, 2000);
                })
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePasswordButtons = document.querySelectorAll(".toggle-password");

            togglePasswordButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const passwordInput = this.closest('.input-group').querySelector(
                        '.password-input');
                    const icon = this.querySelector('i');

                    const type = passwordInput.getAttribute("type") === "password" ? "text" :
                        "password";
                    passwordInput.setAttribute("type", type);

                    icon.classList.toggle("bi-eye");
                    icon.classList.toggle("bi-eye-slash");
                });
            });
        });
    </script>
@endsection
