@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
    <div class="form-header">
        <h1>Create Account</h1>
        <p>Start your journey today</p>
    </div>

    <!-- Tabs -->
    <div class="auth-tabs">
        <a href="{{ route('login') }}" class="auth-tab" data-form="login">Sign In</a>
        <a href="{{ route('registration') }}" class="auth-tab active" data-form="register">Sign Up</a>
    </div>

    @include('layouts.alerts')

    <!-- REGISTER -->
    <form class="auth-form active" id="regForm" method="POST" action="{{ route('registration.post') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="reg-first-name">First Name</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input type="text" class="form-input" name="first_name" id="reg-first-name"
                    value="{{ old('first_name') }}" placeholder="John" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="reg-last-name">Last Name</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <input type="text" class="form-input" name="last_name" id="reg-last-name"
                    value="{{ old('last_name') }}" placeholder="Doe" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="reg-email">Email Address</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                <input type="email" class="form-input" name="email" id="reg-email" value="{{ old('email') }}"
                    placeholder="you@example.com" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="registerPassword">Password</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0110 0v4" />
                </svg>
                <input type="password" class="form-input" name="password" id="registerPassword"
                    placeholder="Create a password" required>
                <button type="button" class="password-toggle" data-target="registerPassword"
                    aria-label="Show password">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
            <div class="password-strength">
                <div class="strength-bar"></div>
                <div class="strength-bar"></div>
                <div class="strength-bar"></div>
                <div class="strength-bar"></div>
            </div>
            <div class="strength-text">Use 8+ characters with upper & lower case letters, numbers and symbols</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="reg-password-confirmation">Repeat Password</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0110 0v4" />
                </svg>
                <input type="password" class="form-input" name="password_confirmation"
                    id="reg-password-confirmation" placeholder="Repeat your password" required>
            </div>
        </div>

        <button type="submit" class="submit-btn">Create Account</button>
    </form>

    <div class="form-footer">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </div>
@endsection
