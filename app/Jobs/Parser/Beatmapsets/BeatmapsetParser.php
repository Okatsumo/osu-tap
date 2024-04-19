<?php

namespace App\Jobs\Parser\Beatmapsets;

use App\Exceptions\OperationError;
use App\Services\Osu\Api\Beatmapsets;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BeatmapsetParser extends BaseOsuParser
{
    protected int $id;
    protected string $request_class = Beatmapsets::class;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @throws OperationError
     */
    public function parse(): void
    {
        try {
            $beatmapset = $this->request->getItem($this->id);
            $this->save($beatmapset);

            foreach ($beatmapset->covers as $url) {
                SaveCover::dispatch($url, $beatmapset->id);
            }

            SavePreview::dispatch($beatmapset->preview_url, $beatmapset->id);
        }
        catch (OperationError $ex) {
            if ($ex->getCode() !== 502) {
                $this->release(60 * 2);
            }

            $this->errorLog($ex);

            if ($ex->getCode() !== 404) {
                $this->fail($ex);
            }
        }
    }

    /**
     * @throws OperationError
     */
    public function save($data): void
    {
        try {
            $this->beatmapsetsRepo->save([
                'id'                => $data->id,
                'artist'            => $data->artist,
                'artist_unicode'    => $data->artist_unicode,
                'creator'           => $data->creator,
                'nsfw'              => $data->nsfw,
                'play_count'        => $data->play_count,
                'source'            => $data->source,
                'spotlight'         => $data->spotlight,
                'status'            => $data->status,
                'title'             => $data->title,
                'title_unicode'     => $data->title_unicode,
                'user_id'           => $data->user_id,
                'video'             => $data->video,
                'bpm'               => $data->bpm,
                'ranked'            => $data->ranked,
                'ranked_date'       => Carbon::parse($data->ranked_date),
                'storyboard'        => $data->storyboard,
                'submitted_date'    => Carbon::parse($data->submitted_date),
                'tags'              => $data->tags,
                'last_updated'      => Carbon::parse($data->last_updated),
            ]);
        } catch (OperationError $ex) {

            if ($ex->getCode() == 23000)  {
                $this->release(60 * 2);
            } else {

                $this->errorLog($ex);
                throw $ex;
            }
        }
    }

    public function errorLog(\Exception $ex)
    {
        Log::error('Osu beatmapset id: '.$this->id.' parser exception => '.$ex);
    }
}
