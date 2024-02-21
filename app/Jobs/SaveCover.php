<?php

namespace App\Jobs;

use App\Base\Api\FileSaver;
use App\Exceptions\OperationError;
use App\Repository\BeatmapsetsRepository;
use App\Services\Api\ApiThrottle;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private FileSaver $fileSaver;
    protected string $url;
    protected string $name;
    protected string $id;
    protected $beatmapsetsRepo;

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

        $this->beatmapsetsRepo = new BeatmapsetsRepository();
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

        try {
            if ($this->apiThrottle->check()) {
                $this->release($this->apiThrottle->getTimeOut());
            }
            else {
                $this->fileSaver->save($this->url, $this->id, $this->name);
            }
        } catch (OperationError $ex) {
            $this->disableCover();
        }

    }

    protected function disableCover(): void
    {
        try {
            $this->beatmapsetsRepo->disabledCover($this->id);
        } catch (OperationError $ex) {
            Log::error('Osu beatmapsets cover parser exception => '.$ex);
        }
    }
}
