<header>
    <div class="header__triangles"></div>
    <nav class="container">
        <div class="nav__menu">
            <div class="nav__menu--logo nav__col">
                <a href="{{route('home')}}" wire:navigate="wire:navigate"><span class="nav__menu--logo__text">OSU!<span class="nav__menu--logo__text--accent">Tap</span></span></a>
            </div>

            <div class="nav__menu--item nav__col">
                <x-nav-link :href="route('scores')" :active="request()->routeIs('scores')" class="nav__menu--link" wire:navigate>Скоры</x-nav-link>
            </div>
            <div class="nav__menu--item nav__col">
                <x-nav-link :href="route('maps')" :active="request()->routeIs('scores')" class="nav__menu--link" wire:navigate>Карты</x-nav-link>
            </div>
        </div>

        <div class="nav__col nav__menu--item">
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
