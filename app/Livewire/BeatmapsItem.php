<?php

namespace App\Livewire;

use App\Models\Beatmapset;
use Livewire\Component;

class BeatmapsItem extends Component
{
    public Beatmapset $beatmapset;

    public function render()
    {
        return view('livewire.beatmaps-item');
    }
}
