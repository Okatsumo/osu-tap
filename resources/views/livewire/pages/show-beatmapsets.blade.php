<div class="beatmaps__items">
    @foreach($beatmapsets as $beatmapset)
        <livewire:beatmaps-item :title="$beatmapset['title']" :artist="$beatmapset['artist']"/>
    @endforeach

    {{$beatmapsets->links()}}
</div>
