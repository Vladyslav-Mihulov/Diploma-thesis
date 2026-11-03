<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · TravelVM</title>
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
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-crypto-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/travelvm.css') }}">
    <!--

TemplateMo 609 Crypto Vault

https://templatemo.com/tm-609-crypto-vault

-->
</head>

<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="dashboard">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            @include('layouts.header')

            @include('layouts.alerts')

            @yield('content')

            <!-- Copyright -->
            @include('layouts.footer')
        </main>
    </div>

    <script src="{{ asset('js/templatemo-crypto-script.js') }}"></script>

    <script>
        document.addEventListener('click', async (e) => {

            const btn = e.target.closest('.star-btn[data-id]');
            if (!btn) return;

            const id = btn.dataset.id;

            try {
                const res = await fetch(`{{ url('/favorite') }}/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                const added = data.status === 'added';

                btn.classList.toggle('active', added);
                btn.textContent = added ? '★' : '☆';

                if (!added && btn.closest('.favorites-page')) {
                    const grid = btn.closest('.staking-grid');
                    btn.closest('.place-card').remove();

                    if (grid && !grid.querySelector('.place-card')) {
                        grid.hidden = true;
                        document.getElementById('favoritesEmpty').hidden = false;
                    }
                }

            } catch (err) {
                console.error('Favorite error:', err);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
