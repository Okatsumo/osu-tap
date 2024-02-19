<?php

namespace App\Jobs;

use App\Exceptions\OperationError;
use App\Services\Api\ApiThrottle;
use App\Services\Osu\Parser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class BeatmapParse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $page;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 0;

    /**
     * Тротлинг api
     */
    protected ApiThrottle $apiThrottle;

    /**
     * Create a new job instance.
     */
    public function __construct(int $page)
    {
        $this->page = $page;
    }


    public function prepare(): void
    {
        $this->apiThrottle = new ApiThrottle('osu', config('services.osu.throttle_settings'));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->prepare();

        try {
            $this->apiThrottle->addCount();

            if ($this->apiThrottle->check()) {
                $this->release($this->apiThrottle->getTimeOut());
            }
            else {
                $parser = new Parser();
                $parser->parseBeatmapsets($this->page);
            }

        } catch (InvalidArgumentException|NotFoundExceptionInterface|ContainerExceptionInterface|OperationError $e) {
            $this->fail($e);
            Log::error('Osu beatmapsets parser exception => '.$e);
        }
    }
}
