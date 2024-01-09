<header>
    <div class="header__triangles"></div>
    <nav class="container">
        <div class="nav__menu">
            <div class="nav__menu--logo nav__col">
                <x-nav-link :href="route('home')" :active="request()->routeIs('scores')"><i class="bi bi-globe-americas nav__menu--logo"></i></x-nav-link>
            </div>

            <div class="nav__menu--link nav__col">
                <x-nav-link :href="route('scores')" :active="request()->routeIs('scores')" wire:navigate>Скоры</x-nav-link>
            </div>
            <div class="nav__menu--link nav__col">
                <x-nav-link :href="route('maps')" :active="request()->routeIs('scores')" wire:navigate>Карты</x-nav-link>
            </div>
        </div>

        <div class="nav__col nav__menu--link">
            @if (Route::has('login'))
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/dashboard') }}">Панель администратора</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Авторизация</a>


                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Регистрация</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>
</header>
