<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<header>
    <div class="header__triangles"></div>
    <nav class="container">
        <div class="nav__col">
            <div class="nav__logo">
                <a href="{{route('home')}}" wire:navigate="wire:navigate"><span class="nav__logo__text">OSU!<span class="nav__logo--text--accent">Tap</span></span></a>
            </div>

            <div class="nav__col--item">
                <x-nav-link :href="route('scores')" :active="request()->routeIs('scores')" class="nav__link" wire:navigate>Скоры</x-nav-link>
            </div>
            <div class="nav__col--item">
                <x-nav-link :href="route('maps')" :active="request()->routeIs('scores')" class="nav__link" wire:navigate>Карты</x-nav-link>
            </div>
        </div>

        <div class="nav__col--item nav__col--menu">
            <a class="nav__link">
                <i class="bi bi-person-circle"></i>
            </a>

            <div class="nav__menu">
                <div class="nav__menu--content">
                    @auth()
                        <a class="button button-pink" href="{{route('dashboard.home')}}">Панель администратора</a>
                        <a class="button button-violet" wire:click="logout">Выйти</a>
                    @else
                        <p class="nav__menu--label">Вы еще не вошли в свой аккаунт, давайте это исправим</p>

                        <a class="button button-pink" href="{{route('dashboard.home')}}">Войти</a>
                        <p class="nav__menu--registration-text">Еще нет аккаунта?
                            <a class="nav__menu--registration-text__button" href="{{route('register')}}">Зарегистрироваться</a>
                        </p>
                    @endauth
                </div>
            </div>

            <span class="nav__menu--bg"/>
        </div>
    </nav>
</header>
