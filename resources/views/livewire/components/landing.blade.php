<div class="landing" style="background-image: linear-gradient(to right, rgb(26 26 26 / 70%) 0 100%), url({{$background_url}})">


    <h1 class="landing--text">Зеркало карт с возможностью просмотра скоров, а так же легкий поиск фармилок для <span class="landing--text__accent">OSU!</span></h1>

    <div class="landing--bottom">
        <div class="landing--bottom__counter-block">
            <h1 class="landing--bottom__text"> Всего карт: <span class="landing--bottom__counter">{{$count}}</span></h1>
        </div>

        <div class="landing--bottom__navigation">
            <x-button color="pink">
                Хочу фармить
            </x-button>
            <x-button :href="route('maps')" :wire_navigate="true">
                Начать поиск
            </x-button>
        </div>
    </div>
</div>
