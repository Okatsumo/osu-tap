<x-main-layout>
    <x-content-title title="Спиоск карт"/>
    <div class="maps__search">
        <input type="text" placeholder="поиск по названию">

        <div class="maps__search-filers">
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Режим</span>
                <a href="#" class="maps__search-filer__item">OSU!</a>
                <a href="#" class="maps__search-filer__item">OSU!Taiko</a>
                <a href="#" class="maps__search-filer__item">OSU!Catch</a>
                <a href="#" class="maps__search-filer__item">OSU!Mania</a>
            </div>
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Язык</span>
                <a href="#" class="maps__search-filer__item">английский</a>
                <a href="#" class="maps__search-filer__item">японский</a>
                <a href="#" class="maps__search-filer__item">русский</a>
                <a href="#" class="maps__search-filer__item">другой</a>
            </div>
            <div class="maps__search-filer">
                <span class="maps__search-filer__header">Откровенное содержание</span>
                <a href="#" class="maps__search-filer__item">присутствует</a>
                <a href="#" class="maps__search-filer__item">отсутствует</a>
            </div>
        </div>
    </div>

    <div class="beatmaps">
        <livewire:pages.show-beatmapsets />
    </div>
</x-main-layout>
