<?php

namespace App\Services\Osu\Api;

use App\Base\Enums\HttpRequestMethods;

class Beatmapsets extends BaseApi
{
    protected string $method = 'beatmapsets';

    public function getBeatmapsets(int $page, string $sort, string $status): mixed
    {
        $params = [
            'page'  => $page ?: 1,
            's'     => $status ?: '',
            'sort'  => $sort ?: '',
            'limit' => 50,
        ];

        return json_decode($this->callApi(HttpRequestMethods::GET, 'search', $params)->getBody());
    }
}
