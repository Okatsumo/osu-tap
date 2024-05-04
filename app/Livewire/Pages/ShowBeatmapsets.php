<?php

namespace App\Livewire\Pages;

use App\Models\Beatmapset;
use Livewire\Component;

class ShowBeatmapsets extends Component
{
    protected $listeners = ['loadMore'];

    public $beatmapsets;
    public int $page = 1;
    public int $perPage = 22;

    public function loadMore(): void
    {
        $this->page++;

        $beatmapsets = Beatmapset::skip(($this->page - 1) * $this->perPage)->take($this->perPage)->get();
        $this->beatmapsets = $this->beatmapsets->concat($beatmapsets);
    }

    public function mount()
    {
        $this->beatmapsets = Beatmapset::take($this->perPage)->get();
    }

    public function render()
    {
        return view('livewire.pages.show-beatmapsets');
    }
}
