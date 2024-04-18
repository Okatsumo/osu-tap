<?php

namespace App\Jobs\Parser\Beatmapsets;

use App\Base\Api\FileSaver;
use App\Base\Enums\HttpRequestMethods;
use App\Exceptions\OperationError;
use App\Repository\BeatmapsetsRepository;
use App\Services\Api\ApiThrottle;
use App\Services\Api\BaseRequest;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SavePreview extends BaseOsuParser
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private FileSaver $fileSaver;
    protected string $url;
    protected string $id;
    protected string $request_class = BaseRequest::class;

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
    public function __construct(string $url, string $id)
    {
        $this->url = $url;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function parse(): void
    {
        try {
            $file = $this->getCover();
            $file->name = 'preview';

            if ($file->type->name == 'mpeg') {
                $file->fullName = 'preview.mp3';
            } else {
                $file->fullName = 'preview.'.$file->type->name;
            }


            $fileSaver = app(FileSaver::class);
            $fileSaver->setDisk('beatmapsets');
            $fileSaver->save($file, (string) $this->id);


        } catch (OperationError) {
            $this->disablePreview();
        }
    }

    /**
     * @throws OperationError
     */
    protected function getCover()
    {
        return $this->request->getFile($this->url);
    }

    protected function disablePreview(): void
    {
        try {
            $this->beatmapsetsRepo->disablePreview($this->id);
        } catch (OperationError $ex) {
            Log::error('Osu beatmapsets cover parser exception => '.$ex);
        }
    }
}
