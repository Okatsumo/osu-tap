<?php

namespace App\Services\Osu\Serializers;

use Illuminate\Support\Carbon;

class BeatmapsetSerializer
{
    public function serialize($data): array
    {
        return [
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
            'ranked_date'       => $data['ranked'] ? Carbon::parse($data['ranked_date']) : null,
            'storyboard'        => $data['storyboard'],
            'submitted_date'    => Carbon::parse($data['submitted_date']),
            'tags'              => $data['tags'],
            'last_updated'      => Carbon::parse($data['last_updated']),
        ];
    }
}
