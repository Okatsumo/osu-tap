<?php

namespace App\Jobs;

use App\Exceptions\OperationError;
use App\Repository\BeatmapsetsRepository;
use App\Services\Api\ApiThrottle;
use App\Services\Osu\Api\Beatmapsets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

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
