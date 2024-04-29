<div class="beatmaps__items">
    @foreach($beatmapsets as $beatmapset)
        <livewire:beatmaps-item :beatmapset="$beatmapset" wire:key="beatmapset-{{$beatmapset->id}}"/>
    @endforeach

    <div>
        {{$beatmapsets->links('vendor.pagination.default')}}
    </div>
</div>
