<div class="beatmaps__item">
    <div class="beatmap-panel">
        <div class="beatmaps-panel__cover-container">
            <a href="#" class="beatmaps-panel__cover-col beatmaps__item__images-col-play">
                <div class="beatmap-cover beatmap-cover--full" style="background-image: url({{$beatmapset->cover}});"></div>
            </a>
            <div class="beatmaps-panel__cover-col beatmaps__item__images-col-info">
                <div class="beatmaps__item__images-information beatmapset-cover--full" style="background-image: url({{$beatmapset->card}});"></div>
            </div>
        </div>
        <div class="beatmaps__item__content">
            <a class="beatmaps__item__content-play">
                <i class="beatmaps__item__content-play__item beatmaps__item__content__icon-play bi bi-play-fill"></i>
            </a>
            <div class="beatmaps__item__content-info">
                <a class="beatmaps__item__title" href="#">{{$beatmapset->title}}</a>
                <a class="beatmaps__item__artist" href="#">От {{$beatmapset->artist}}</a>
                <p>{{$beatmapset->creator}}</p>
            </div>

            <a href="#" class="beatmaps__item__content-background">
                <i class="bi bi-file-arrow-down"></i>
            </a>
        </div>
    </div>
</div>
