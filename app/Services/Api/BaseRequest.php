<?php

namespace App\Services\Api;

use App\Base\Dto\File;
use App\Base\Dto\Proxy;
use App\Base\Enums\FileType;
use App\Base\Enums\HttpRequestMethods;
use App\Exceptions\OperationError;
use App\Services\Osu\Dto\OsuAccount;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class BaseRequest
{
    protected int $client_id;
    protected string $client_secret;
    protected string $access_token;
    protected string $user_agent;
    public Proxy|null $proxy = null;

    /**
     * @throws OperationError
     */
    public function call(HttpRequestMethods $method, string $url, array $params = []): ResponseInterface
    {
        $proxy_url = '';

        if ($this->proxy) {
            $proxy_url = $this->proxy->type->name.'://' .$this->proxy->login.':' .$this->proxy->password.'@' .$this->proxy->host.':' .$this->proxy->port;
        }

        $http_client = new Client([
            'proxy' => $proxy_url,
            'headers' => [
                'User-Agent' => $this->user_agent,
                'Authorization' => 'Bearer '.$this->access_token,
                'Accept'        => 'application/json'
            ],
        ]);

        try {
            if ($method->value == 'GET') {
                return $http_client->request('GET', $url, ['query' => $params]);
            }

            return $http_client->request($method->value, $url, ['form_params' => $params]);
        } catch (ClientException|GuzzleException $ex) {

            if ($ex->getCode() == 404) {
                throw new OperationError('Not found', 404);
            }

            throw new OperationError($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @param string $url
     * @return File
     * @throws OperationError
     */
    public function getFile(string $url): File
    {
        $request = $this->call(HttpRequestMethods::GET, $url);

        $contentType = $request->getHeaderLine('content-type');
        $size = $request->getBody()->getSize();

        $tagBefore = stristr($url, '?', true);

        if ($tagBefore) {
            $url = $tagBefore;
        }

        $url = explode('/', $url);
        $fullName = end($url);
        $name_array = explode('.', $fullName);
        $name = $name_array[0];

        return new File($fullName, $name, $size, FileType::from($contentType), $request->getBody()->getContents());
    }

    public function setAccount(OsuAccount $account): void
    {
        $this->proxy = $account->proxy;

        $this->client_id = $account->client_id;
        $this->client_secret = $account->client_secret;
        $this->access_token = $account->access_token;
        $this->user_agent = $account->user_agent;
    }
}
