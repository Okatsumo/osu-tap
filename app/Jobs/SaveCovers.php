<?php

namespace App\Jobs;

use App\Base\Api\FileSaver;
use App\Exceptions\OperationError;
use App\Services\Api\ApiThrottle;
use App\Services\Osu\Parser;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveCovers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private FileSaver $fileSaver;
    protected string $url;
    protected string $name;
    protected string $id;

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
    public function __construct(string $url, string $name, string $id)
    {
        $this->url = $url;
        $this->name = $name;
        $this->id = $id;
    }

    protected function prepare(): void
    {
        $this->apiThrottle = new ApiThrottle('osu', config('services.osu.throttle_settings'));
        $this->fileSaver = app(FileSaver::class);
        $this->fileSaver->setDisk('beatmapsets');
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
        }
        else {

            try {
                $this->fileSaver->save($this->url, 'covers/'.$this->name, $this->name);
            } catch (OperationError|GuzzleException $e) {

            }
        }
    }
}
