<?php

namespace App\Services\Osu;

use App\Models\Beatmapset;
use App\Services\Osu\Api\Beatmapsets;

class Parser
{
    public function parseBeatmapsets(int $page = 1)
    {
        $beatmapsets = new Beatmapsets();

        $data = $beatmapsets->getBeatmapsets($page);

        foreach ($data['beatmapsets'] as $beatmapset) {
            $this->saveBeatmapset($beatmapset);
        }
    }


    private function saveBeatmapset($data)
    {
        Beatmapset::create([
//            'id'                => $data['id'],
            'artist'            => $data['artist'],
            'artist_unicode'    => $data['artist_unicode'],
            'cover'             => '123',
            'creator'           => $data['creator'],
            'nsfw'              => $data['nsfw'],
            'play_count'        => $data['play_count'],
            'preview_url'       => $data['preview_url'],
            'source'            => $data['source'],
            'spotlight'         => $data['spotlight'],
            'status'            => $data['status'],
            'title'             => $data['title'],
            'title_unicode'     => $data['title_unicode'],
            'user_id'           => $data['user_id'],
            'video'             => $data['video'],
            'bpm'               => $data['bpm'],
            'ranked'            => $data['ranked'],
//            'ranked_date'       => $data['ranked_date'],
            'storyboard'        => $data['storyboard'],
//            'submitted_date'    => $data['submitted_date'],
            'tags'              => 'test'
        ]);
    }
}
