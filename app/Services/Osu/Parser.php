<?php

namespace App\Services\Osu;

use App\Base\Api\FileSaver;
use App\Exceptions\OperationError;
use App\Jobs\SaveCover;
use App\Jobs\SavePreview;
use App\Models\Beatmapset;
use App\Repository\BeatmapsetsRepository;
use App\Services\Osu\Api\Beatmapsets;
use Illuminate\Support\Carbon;

class Parser
{
    protected $repo;

    public function __construct()
    {
        $this->repo = new BeatmapsetsRepository();
    }

    /**
     * @throws OperationError
     */
    public function parseBeatmapsets(int $page = 1)
    {
        $beatmapsets = new Beatmapsets();

        $data = $beatmapsets->getBeatmapsets($page);

        if (array_key_exists('authentication', $data)) {
            throw new OperationError('Authentication exception', 401);
        }
        if (!array_key_exists('beatmapsets', $data)) {
            throw new OperationError('Beatmapsets not found', 404);
        }

        foreach ($data['beatmapsets'] as $beatmapset) {
            $this->saveBeatmapset($beatmapset);
        }
    }

    private function saveBeatmapset($data)
    {
        $item = [
            'id'                => $data['id'],
            'artist'            => $data['artist'],
            'artist_unicode'    => $data['artist_unicode'],
            'creator'           => $data['creator'],
            'nsfw'              => $data['nsfw'],
            'play_count'        => $data['play_count'],
            'source'            => $data['source'],
            'spotlight'         => $data['spotlight'],
            'status'            => $data['status'],
            'title'             => $data['title'],
            'title_unicode'     => $data['title_unicode'],
            'user_id'           => $data['user_id'],
            'video'             => $data['video'],
            'bpm'               => $data['bpm'],
            'ranked'            => $data['ranked'],
            'ranked_date'       => Carbon::parse($data['ranked_date']),
            'storyboard'        => $data['storyboard'],
            'submitted_date'    => Carbon::parse($data['submitted_date']),
            'tags'              => $data['tags'],
            'last_updated'      => Carbon::parse($data['last_updated'])
        ];

        $this->repo->save($item);

        SavePreview::dispatch($data['preview_url'], $data['id']);

        foreach ($data['covers'] as $cover_name => $url) {
            SaveCover::dispatch($url, $cover_name, $data['id']);
        }
    }
}
