<?php

namespace App\Services\Osu\Api;

use App\Services\Osu\Dto\OsuAccount;
use GuzzleHttp\Client;

class TokensHandler
{
    private Client $http_client;
    private string $auth_url;
    private string $access_token_url;
    private string $scopes;

    public function __construct(protected OsuAccount $account)
    {
        $this->auth_url = config('services.osu.auth_url');
        $this->access_token_url = config('services.osu.access_token_url');
        $this->scopes = config('services.osu.scopes');
    }

    public function checkAndUpdateAccessToken(): void
    {
        if (!$this->isActiveAccessToken()) {
            $this->updateAccessToken();
        }
    }

    protected function updateAccessToken(): void
    {
        $body = [
            'client_id'     => $this->account->client_id,
            'client_secret' => $this->account->client_secret,
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->account->refresh_token,
            'scope'         => $this->scopes,
        ];
        $this->initialClient($body);

        $data = $this->http_client
            ->post($this->access_token_url)
            ->getBody();

        $data = json_decode($data);

        $this->account->access_token = $data->access_token;
        $this->account->refresh_token = $data->refresh_token;
        $this->account->expires_in = $data->expires_in;
    }

    protected function initialClient(array $params = []): void
    {
        $proxy_url = $this->account->proxy->type->name.'://' .$this->account->proxy->login.':' .$this->account->proxy->password.'@' .$this->account->proxy->host.':' .$this->account->proxy->port;

        $this->http_client = new Client([
            'proxy' => $proxy_url,
            'form_params' => $params,
            'headers' => [
                'User-Agent'    => $this->account->user_agent,
                'Authorization' => 'Bearer '.$this->account->access_token,
                'Accept'        => 'application/x-www-form-urlencoded'
            ],
        ]);
    }

    protected function isActiveAccessToken(): bool
    {
        if (time() > $this->account->created_at->timestamp + $this->account->expires_in) {
            return false;
        }

        return true;
    }

    public function getAccount(): OsuAccount
    {
        return $this->account;
    }

}
