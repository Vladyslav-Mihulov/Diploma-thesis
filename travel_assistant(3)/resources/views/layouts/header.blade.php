<div class="header">
    <div class="header-left">
        <h1>@yield('title', 'Dashboard')</h1>
        <p class="header-subtitle">@yield('subtitle', 'Welcome back!')</p>
    </div>

    <div class="header-right">

        @auth
            @php($user = Auth::user()->loadMissing('roles'))

            <a href="{{ route('profile') }}" class="user-menu">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->f_name, 0, 1)) }}{{ strtoupper(substr($user->l_name, 0, 1)) }}
                </div>

                <div class="user-info">
                    <span class="user-name">{{ $user->f_name }} {{ $user->l_name }}</span>
                    <span class="user-role">{{ $user->roles->pluck('name')->implode(', ') ?: 'User' }}</span>
                </div>
            </a>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="user-menu">
                <div class="user-avatar">G</div>

                <div class="user-info">
                    <span class="user-name">Guest</span>
                    <span class="user-role">Sign in to save searches</span>
                </div>
            </a>
        @endguest

    </div>
</div>
