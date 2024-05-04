<div class="beatmaps__items" wire:scroll="loadMore">
    @foreach($beatmapsets as $beatmapset)
        <livewire:beatmaps-item :beatmapset="$beatmapset" wire:key="beatmapset-{{$beatmapset->id}}"/>
    @endforeach

</div>
