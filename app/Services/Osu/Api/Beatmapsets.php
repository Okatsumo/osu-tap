<?php

namespace App\Services\Osu\Api;

class Beatmapsets extends BaseApi
{
    public $method = 'beatmapsets';

    public function getBeatmapsets(int $page = 1)
    {
        $params = [
            'page'  => $page,
            'sort'  => 'ranked_asc',
            'limit' => '1'
        ];

        return $this->callApi('search', $params)->json();
    }
}
