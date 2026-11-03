@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    <div class="form-header">
        <h1>Welcome Back</h1>
        <p>Enter your credentials to access your account</p>
    </div>

    <!-- Tabs -->
    <div class="auth-tabs">
        <a href="{{ route('login') }}" class="auth-tab active" data-form="login">Sign In</a>
        <a href="{{ route('registration') }}" class="auth-tab" data-form="register">Sign Up</a>
    </div>

    @include('layouts.alerts')

    <!-- LOGIN -->
    <form class="auth-form active" id="logForm" method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="login-email">Email Address</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                <input type="email" class="form-input" name="email" id="login-email" value="{{ old('email') }}"
                    placeholder="you@example.com" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="login-password">Password</label>
            <div class="form-input-wrapper">
                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0110 0v4" />
                </svg>
                <input type="password" class="form-input" name="password" id="login-password"
                    placeholder="Enter your password" required>
                <button type="button" class="password-toggle" data-target="login-password" aria-label="Show password">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="submit-btn">Sign In</button>
    </form>

    <div class="form-footer">
        Don't have an account? <a href="{{ route('registration') }}">Sign up</a>
    </div>
@endsection
