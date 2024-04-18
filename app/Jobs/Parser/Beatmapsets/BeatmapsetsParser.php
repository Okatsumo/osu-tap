<?php

namespace App\Jobs\Parser\Beatmapsets;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BeatmapsetsParser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 0;
    private int $startId;
    private int $endId;

    public function __construct(int $startId, int $endId)
    {
        $this->startId = $startId;
        $this->endId = $endId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        for ($id = $this->startId; $id <= $this->endId; $id++) {
            BeatmapsetParser::dispatch($id);
        }
    }
}
