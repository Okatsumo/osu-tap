<?php

namespace App\Services\Osu\Api;

use App\Base\Enums\HttpRequestMethods;
use App\Exceptions\OperationError;
use App\Services\Api\BaseRequest;
use Psr\Http\Message\ResponseInterface;

class BaseApi extends BaseRequest
{
    protected string $method = '';
    protected string $base_url;

    public function __construct()
    {
        $this->base_url = config('services.osu.base_url');
    }

    /**
     * @throws OperationError
     */
    protected function callApi(HttpRequestMethods $method, string $url, array $params = []): ResponseInterface
    {
        $path = $this->base_url.$this->method.'/'.$url;

        return $this->call($method, $path, $params);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws OperationError
     */
    public function getItem(int $id): mixed
    {
        $result = $this->callApi(HttpRequestMethods::GET, $id);

        return json_decode($result->getBody());
    }
}
