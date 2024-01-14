<?php

namespace App\Jobs;

use App\Services\Api\ApiThrottle;
use App\Services\Osu\Parser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        if ($this->apiThrottle->check()) {
            $this->release($this->apiThrottle->getTimeOut() + 5);
        }
        else {
            $parser = new Parser();
            $parser->parseBeatmapsets($this->page);

            $this->apiThrottle->addCount();
        }
    }
}
