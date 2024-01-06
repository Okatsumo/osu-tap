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

        <div class="nav__col">
            @if (Route::has('login'))
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Панель администратора</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Авторизация</a>


                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Регистрация</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>
</header>
