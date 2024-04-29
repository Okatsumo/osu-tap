<div class="landing" style="background-image: linear-gradient(to right, rgb(26 26 26 / 70%) 0 100%), url({{$background_url}})">


    <h1 class="landing--text">Зеркало карт с возможностью просмотра скоров, а так же легкий поиск фармилок для <span class="landing--text__accent">OSU!</span></h1>

    <div class="landing--bottom">
        <div class="landing--bottom__counter-block">
            <h1 class="landing--bottom__text"> Всего карт: <span class="landing--bottom__counter">4158139</span></h1>
        </div>

        <div class="landing--bottom__navigation">
            <button class="button button-pink landing--bottom__button">
                Хочу фармить
            </button>
            <button href="{{route('maps')}}" wire:navigate="wire:navigate" class="button button-violet landing--bottom__button">
                Начать поиск
            </button>
        </div>
    </div>
</div>
