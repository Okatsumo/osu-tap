<?php

namespace App\Livewire;

use Livewire\Component;

class BeatmapsItem extends Component
{
    public string $title;
    public string $artist;

    public function render()
    {
        return view('livewire.beatmaps-item');
    }
}
