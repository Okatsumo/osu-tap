<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Landing extends Component
{
    public function render()
    {
        return view('livewire.components.landing', [
            'background_url' => 'https://assets.ppy.sh/beatmaps/2116408/covers/cover.jpg?1711581881',
            'count' => 4158139,
        ]);
    }
}
