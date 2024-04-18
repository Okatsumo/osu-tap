<?php

namespace App\Livewire\Pages;

use App\Models\Beatmapset;
use Livewire\Component;

class ShowBeatmapsets extends Component
{

    public function render()
    {
        return view('livewire.pages.show-beatmapsets', [
            'beatmapsets' => Beatmapset::paginate(12)
        ]);
    }
}
