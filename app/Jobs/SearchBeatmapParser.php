<?php

namespace App\Jobs;

use App\Exceptions\OperationError;
use App\Services\Api\ApiThrottle;
use App\Services\Osu\Api\Beatmapsets;
use App\Services\Osu\Parser\BeatmapestsParser;
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

class SearchBeatmapParser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $page;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 0;
    public string $sort;
    public string $status;
    public $api;

    /**
     * Тротлинг api
     */
    protected ApiThrottle $apiThrottle;

    /**
     * Create a new job instance.
     */
    public function __construct(int $page, string $sort, string $status)
    {
        $this->page = $page;
        $this->sort = $sort;
        $this->status = $status;

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
        $this->apiThrottle->addCount();

        if ($this->apiThrottle->check()) {
            $this->release($this->apiThrottle->getTimeOut());
        } else {
            $this->parse();
        }
    }


    public function parse()
    {
        try {
            $parser = new BeatmapestsParser();

            $parser->parse($this->page, $this->sort, $this->status);

        } catch (InvalidArgumentException|NotFoundExceptionInterface|ContainerExceptionInterface|OperationError $e) {
            $this->fail($e);
            Log::error('Osu beatmapsets parser exception => '.$e);
        }
    }
}
