<?php

namespace App\Jobs\Parser\Beatmapsets;

use App\Base\Api\FileSaver;
use App\Exceptions\OperationError;
use App\Services\Api\BaseRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveCover extends BaseOsuParser
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $url;
    protected string $name;
    protected int $id;
    protected string $request_class = BaseRequest::class;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(string $url, int $id)
    {
        $this->url = $url;
        $this->id = $id;
    }

    /**
     * @throws OperationError
     */
    public function parse(): void
    {
        try {
            $file = $this->request->getFile($this->url);

            $fileSaver = app(FileSaver::class);
            $fileSaver->setDisk('beatmapsets');
            $fileSaver->save($file, (string) $this->id);

        } catch (OperationError) {
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
