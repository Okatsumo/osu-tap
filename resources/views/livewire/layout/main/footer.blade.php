<footer>
    <div class="footer__content container">
        <div class="footer__col footer__about">
            <h1 class="footer__col--name">
                OSU!<span>Tap</span>
            </h1>
            <p>Поиск карт для фарма, просмотр топовых скоров, а так же загрузка карт для OSU! без регистрации</p>
        </div>
        <div class="footer__col">
            <h1>Навигация</h1>
            <ul>
                <li><a href="{{route('maps')}}" wire:navigate="wire:navigate">Карты</a></li>
                <li><a href="{{route('scores')}}" wire:navigate="wire:navigate">Скоры</a></li>
            </ul>
        </div>
        <div class="footer__col">
            <h1>О проекте</h1>
            <ul>
                <li><a href="#">Разработчики</a></li>
                <li><a href="#">Контакты</a></li>
            </ul>
        </div>
    </div>
</footer>
