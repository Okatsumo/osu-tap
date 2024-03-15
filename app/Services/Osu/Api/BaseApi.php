<?php

namespace App\Services\Osu\Api;

use App\Exceptions\OperationError;
use Illuminate\Support\Facades\Http;

class BaseApi
{
    public $base_url;
    public $auth_url;
    public $client_id;
    public $client_secret;
    public $token;
    public $method = '';


    public function __construct()
    {
        $this->base_url = config('services.osu.base_url');
        $this->auth_url = config('services.osu.aut_url');
        $this->client_id = config('services.osu.client_id');
        $this->client_secret = config('services.osu.client_secret');
        $this->token = config('services.osu.token');
    }

    public function callApi(string $url, array $params = [])
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get($this->base_url . $this->method . '/' . $url, $params);
    }

    /**
     * @throws OperationError
     */
    public function getItem(int $id)
    {
        $result = $this->callApi($id);

        if ($result->status() === 404) {
            throw new OperationError('item not found', 404);
        }

        return $result->json();
    }
}
