<x-main-layout>
    <x-content-title title="Список карт"/>
    <div class="maps__search" style="background-image: linear-gradient(to right, rgb(26 26 26 / 90%) 0 100%), url(https://assets.ppy.sh/beatmaps/2116408/covers/cover.jpg?1711581881)">
        <input type="text" placeholder="поиск по названию">

        <div class="maps__search-filers">
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Режим</span>
                <a href="#" class="maps__search-filer__item search-filer__item--active">Все</a>
                <a href="#" class="maps__search-filer__item">OSU!</a>
                <a href="#" class="maps__search-filer__item">OSU!Taiko</a>
                <a href="#" class="maps__search-filer__item">OSU!Catch</a>
                <a href="#" class="maps__search-filer__item">OSU!Mania</a>
            </div>
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Сложность</span>
                <a href="#" class="maps__search-filer__item search-filer__item--active">Все</a>
                <a href="#" class="maps__search-filer__item">1-3</a>
                <a href="#" class="maps__search-filer__item">4-6</a>
                <a href="#" class="maps__search-filer__item">7-10</a>
            </div>
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Категории</span>
                <a href="#" class="maps__search-filer__item">Все</a>
                <a href="#" class="maps__search-filer__item search-filer__item--active">С таблицей рекордов</a>
                <a href="#" class="maps__search-filer__item">Рейтинговые</a>
                <a href="#" class="maps__search-filer__item">Квалифицированные</a>
                <a href="#" class="maps__search-filer__item">Любимые</a>
                <a href="#" class="maps__search-filer__item">На рассмотрении</a>
            </div>
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Язык</span>
                <a href="#" class="maps__search-filer__item search-filer__item--active">Все</a>
                <a href="#" class="maps__search-filer__item">английский</a>
                <a href="#" class="maps__search-filer__item">японский</a>
                <a href="#" class="maps__search-filer__item">русский</a>
                <a href="#" class="maps__search-filer__item">другой</a>
            </div>
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Сортировка</span>
                <a href="#" class="maps__search-filer__item search-filer__item--active">От новых к старым</a>
                <a href="#" class="maps__search-filer__item">От сложных к легким</a>
                <a href="#" class="maps__search-filer__item">Максимальное PP</a>
            </div>
        </div>
    </div>

    <div class="beatmaps">
        <livewire:pages.show-beatmapsets />
    </div>
</x-main-layout>
