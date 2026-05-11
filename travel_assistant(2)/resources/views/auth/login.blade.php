@extends('layouts.main')

@section('content')

    @if ($errors->any())
        <div class="block-error">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">

        <div class="form-header">
            <h1>Welcome Back</h1>
            <p>Enter your credentials to access your account</p>
        </div>

        <!-- Tabs -->
        <div class="auth-tabs">
            <button type="button" class="auth-tab active {{ request()->routeIs('login') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('login') }}'">
                Sign In
            </button>

            <button type="button" class="auth-tab  {{ request()->routeIs('register') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('registration') }}'">
                Sign Up
            </button>
        </div>

        <!-- LOGIN -->
        <form class="form-grid" id="logForm" method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" name="email" id="login-email" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-input" name="password" id="login-password" required>
            </div>

            <button type="submit" class="submit-btn">Sign In</button>
        </form>

        
    </div>

@endsection
