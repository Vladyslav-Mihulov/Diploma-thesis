<div class="header">
    <div class="header-left">
        <h1>Dashboard</h1>
        <p class="header-subtitle">Welcome back!</p>
    </div>

    <div class="header-right">

        @auth
            @php($user = Auth::user()->load('roles'))

            <div class="user-menu">

                <div class="user-avatar">
                    {{ strtoupper(substr($user->f_name, 0, 1)) }}
                    {{ strtoupper(substr($user->l_name, 0, 1)) }}
                </div>

                <div class="user-info">
                    <span class="user-name">
                        {{ $user->f_name }} {{ $user->l_name }}
                    </span>

                    <div class="roles-wrapper">
                        @foreach ($user->roles as $role)
                            <span class="user-role">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

            </div>
        @endauth


        @guest
            <div class="user-menu">

                <div class="user-avatar">
                    G
                </div>

                <div class="user-info">
                    <span class="user-name">Guest</span>

                    <span class="user-role">
                        <a>Guest</a>
                    </span>
                </div>

            </div>
        @endguest

    </div>
</div>
