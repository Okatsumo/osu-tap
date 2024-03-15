<?php

namespace App\Services\Osu\Api;

use App\Exceptions\Handler as ExceptionsHandler;
use App\Exceptions\OperationError;

class Beatmapsets extends BaseApi
{
    public $method = 'beatmapsets';

    /**
     * @throws OperationError
     */
    public function getBeatmapsets(int $page, string $sort, string $status)
    {
        $params = [
            'page'  => $page ?: 1,
            's'     => $status ?: '',
            'sort'  => $sort ?: '',
            'limit' => 50
        ];

        return $this->callApi('search', $params)->json();
    }

    public function getTotalPages(string $sort = 'ranked_asc', int $itemsLimit = 50): int
    {
        $data = $this->getBeatmapsets();
        $pages = $data['total'] / $itemsLimit;

        return round($pages);
    }
}
