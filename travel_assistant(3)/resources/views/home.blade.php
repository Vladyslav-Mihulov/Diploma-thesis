@extends('layouts.main')

@section('title', 'Home')
@section('subtitle', auth()->check() ? 'Welcome back, ' . auth()->user()->f_name . '!' : 'Welcome to TravelVM!')

@section('content')
    <div class="balance-cards">
        <a href="{{ route('search') }}" class="balance-card primary">
            <div class="balance-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </div>
            <div class="balance-value">Search</div>
            <div class="balance-label">Find places to relax near your address</div>
        </a>

        @auth
            <a href="{{ route('history') }}" class="balance-card">
                <div class="balance-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div class="balance-value">History</div>
                <div class="balance-label">Review your previous searches and results</div>
            </a>

            <a href="{{ route('favorites') }}" class="balance-card">
                <div class="balance-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <div class="balance-value">Favorites</div>
                <div class="balance-label">Places you have saved for later</div>
            </a>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="balance-card">
                <div class="balance-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                </div>
                <div class="balance-value">Sign In</div>
                <div class="balance-label">Access your history and favorites</div>
            </a>

            <a href="{{ route('registration') }}" class="balance-card">
                <div class="balance-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                </div>
                <div class="balance-value">Sign Up</div>
                <div class="balance-label">Create an account to save your searches</div>
            </a>
        @endguest
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">About TravelVM</div>
                <div class="card-description">Your personal travel assistant</div>
            </div>
        </div>

        <div class="toggle-item">
            <div class="toggle-info">
                <div class="toggle-title">1. Enter your address</div>
                <div class="toggle-description">Start typing and pick your address from the suggestions.</div>
            </div>
        </div>
        <div class="toggle-item">
            <div class="toggle-info">
                <div class="toggle-title">2. Choose the type and distance of travel</div>
                <div class="toggle-description">Beach, hiking, culture, gastronomy, nature and more — up to 500 km away.
                </div>
            </div>
        </div>
        <div class="toggle-item">
            <div class="toggle-info">
                <div class="toggle-title">3. Discover places</div>
                <div class="toggle-description">Get nearby attractions with AI descriptions and ratings, and save the
                    best ones to your favorites.</div>
            </div>
        </div>
    </div>
@endsection
