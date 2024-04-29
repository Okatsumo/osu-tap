<?php

namespace App\Services\Osu\Parser;

use App\Jobs\Parser\Beatmapsets\BeatmapsetsPageParser;
use App\Jobs\Parser\Beatmapsets\BeatmapsetsStartParser;
use App\Repository\BeatmapsetsRepository;
use App\Services\Osu\Api\Beatmapsets;

final class Parser
{
    protected Beatmapsets $api;
    protected BeatmapsetsRepository $repo;

    public function __construct()
    {
        $this->api = new Beatmapsets();
        $this->repo = new BeatmapsetsRepository();
    }

    public function start(): void
    {
        $this->searchParser('id_asc');
        $this->searchParser('id_dec');

        BeatmapsetsStartParser::dispatch()->onQueue('parser');
    }

    private function searchParser(string $sort): void
    {
        for ($page = 1; $page <= 200; $page++) {
            BeatmapsetsPageParser::dispatch($page, $sort, 'any')->onQueue('parser');
        }
    }
}
