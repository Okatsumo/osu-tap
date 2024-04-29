<?php

namespace App\Jobs\Parser\Beatmapsets;

use App\Services\Osu\Api\Beatmapsets;

class BeatmapsetsStartParser extends BaseOsuParser
{
    protected string $request_class = Beatmapsets::class;

    public function parse(): void
    {
        $ascItems = $this->request->getBeatmapsets(200, 'ranked_asc', 'any')->beatmapsets;
        $decItems = $this->request->getBeatmapsets(1, 'ranked_dec', 'any')->beatmapsets;

        $startId = end($ascItems)->id + 1;
        $endId = end($decItems)->id;

        $chunkSize = 500;
        $startChunk = $startId;
        $endChunk = $startChunk + 500;

        while ($startChunk <= $endChunk) {
            BeatmapsetsParser::dispatch($startChunk, $endChunk)->onQueue('parser');

            $startChunk += $chunkSize;
            $endChunk = min($endChunk + $chunkSize, $endId);
        }
    }
}
