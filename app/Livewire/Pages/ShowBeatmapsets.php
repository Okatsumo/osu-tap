<?php

namespace App\Livewire\Pages;

use App\Models\Beatmapset;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBeatmapsets extends Component
{
    use WithPagination;
    public Beatmapset $beatmapset;

    public function render()
    {
        return view('livewire.pages.show-beatmapsets', [
            'beatmapsets' => Beatmapset::paginate(12),
        ]);
    }
}
