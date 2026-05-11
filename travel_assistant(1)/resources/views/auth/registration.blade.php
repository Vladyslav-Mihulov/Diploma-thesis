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
            <h1>Create Account</h1>
            <p>Start your crypto journey today</p>
        </div>

        <!-- Tabs -->
        <div class="auth-tabs">
            <button type="button" class="auth-tab {{ request()->routeIs('login') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('login') }}'">
                Sign In
            </button>

            <button type="button" class="auth-tab active {{ request()->routeIs('register') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('registration') }}'">
                Sign Up
            </button>
        </div>

        <!-- REGISTER -->
        <form class="form-grid" id="regForm" method="POST" action="{{ route('registration.post') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" class="form-input" name="first_name" required>
            </div>

            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-input" name="last_name" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" name="email" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-input" name="password" required>
            </div>

            <div class="form-group">
                <label class="form-label">Repeat Password</label>
                <input type="password" class="form-input" name="password_confirmation" required>
            </div>

            <button type="submit" class="submit-btn">Create Account</button>
        </form>
    @endsection
