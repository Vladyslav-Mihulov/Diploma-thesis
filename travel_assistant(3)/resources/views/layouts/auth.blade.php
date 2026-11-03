<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') · TravelVM</title>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travelvm.css') }}">
    <!--

TemplateMo 609 Crypto Vault

https://templatemo.com/tm-609-crypto-vault

-->
</head>

<body class="auth-page">
    <div class="auth-branding">
        <div class="branding-content">
            <div class="branding-logo">T</div>
            <h1 class="branding-title">TravelVM</h1>
            <p class="branding-subtitle">Find the perfect place to relax and unwind near your location</p>

            <div class="branding-features">
                <div class="branding-feature">
                    <div class="feature-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <span>Places nearby your address</span>
                </div>
                <div class="branding-feature">
                    <div class="feature-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polygon
                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>
                    <span>AI descriptions and ratings</span>
                </div>
                <div class="branding-feature">
                    <div class="feature-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <span>Search history and favorites</span>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-form-container">
        <button class="theme-toggle-btn" id="themeToggle" type="button" aria-label="Toggle theme">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
                <circle cx="12" cy="12" r="5" />
                <line x1="12" y1="1" x2="12" y2="3" />
                <line x1="12" y1="21" x2="12" y2="23" />
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                <line x1="1" y1="12" x2="3" y2="12" />
                <line x1="21" y1="12" x2="23" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </svg>
        </button>

        <div class="auth-form-wrapper">
            @yield('content')

            <div class="form-footer">
                <a href="{{ route('home') }}">← Back to TravelVM</a>
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <script src="{{ asset('js/templatemo-crypto-script.js') }}"></script>
</body>

</html>
