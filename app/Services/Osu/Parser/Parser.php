<?php

namespace App\Services\Osu\Parser;

use App\Jobs\BeatmapsetsParser;
use App\Jobs\SearchBeatmapParser;
use App\Repository\BeatmapsetsRepository;
use App\Services\Osu\Api\Beatmapsets;

class Parser
{
    private $api;
    private $repo;

    public function __construct()
    {
        $this->api = new Beatmapsets();
        $this->repo = new BeatmapsetsRepository();
    }

    public function start()
    {
        $this->searchParser('ranked_asc', 'any');
        $this->searchParser('ranked_dec', 'any');

        $ascItems = $this->api->getBeatmapsets(200, 'ranked_asc', 'any')['beatmapsets'];
        $decItems = $this->api->getBeatmapsets(1, 'ranked_dec', 'any')['beatmapsets'];

        $startId = end($ascItems)['id'] + 1;
        $endId = end($decItems)['id'];

        $this->parser($startId, $endId);
    }

    private function parser(int $startId, int $endId)
    {
        $chunkSize = 500;

        $startChunk = $startId;
        $endChunk = $startChunk + 500;

        while ($startChunk <= $endChunk) {
            BeatmapsetsParser::dispatch($startChunk, $endChunk);

            $startChunk += $chunkSize;
            $endChunk = min($endChunk + $chunkSize, $endId);
        }
    }

    private function searchParser(string $sort, string $status): void
    {
        for ($page = 1; $page <= 200; $page++) {
            SearchBeatmapParser::dispatch($page, $sort, $status);
        }
    }
}
