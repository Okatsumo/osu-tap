<?php

namespace App\Jobs\Parser\Beatmapsets;

use App\Exceptions\OperationError;
use App\Repository\BeatmapsetsRepository;
use App\Services\Osu\Api\Beatmapsets;
use Illuminate\Support\Carbon;

class BeatmapsetsPageParser extends BaseOsuParser
{
    protected int $tries = 20;
    private int $page;
    private string $sort;
    private string $status;
    protected string $request_class = Beatmapsets::class;

    public function __construct(int $page = 1, string $sort = 'ranked_asc', $status = 'any')
    {
        $this->page = $page;
        $this->sort = $sort;
        $this->status = $status;
    }

    public function parse(): void
    {
        try {
            $data = $this->request->getBeatmapsets($this->page, $this->sort, $this->status);

            foreach ($data->beatmapsets as $beatmapset) {
                $this->save($beatmapset);

                SavePreview::dispatch($beatmapset->preview_url, $beatmapset->id);

                foreach ($beatmapset->covers as $url) {
                    SaveCover::dispatch($url, $beatmapset->id);
                }
            }

        } catch (OperationError $ex) {

            if ($ex->getCode() !== 502) {
                $this->release(60 * 2);
            }
        }
    }

    /**
     * @throws OperationError
     */
    private function save($data): void
    {
        $repo = new BeatmapsetsRepository();

        $item = [
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
        ];

        try {
            $repo->save($item);
        } catch (OperationError $ex) {

            if ($ex->getCode() == 23000)  {
                $repo->update($data->id, $item);
            } else {
                throw $ex;
            }
        }
    }
}
