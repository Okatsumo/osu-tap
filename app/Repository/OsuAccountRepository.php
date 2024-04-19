<?php

namespace App\Repository;

use App\Base\Dto\Proxy;
use App\Services\Osu\Api\TokensHandler;
use App\Services\Osu\Dto\OsuAccount;
use Illuminate\Contracts\Cache\Store;

class OsuAccountRepository
{
    protected \App\Models\OsuAccount $eloquent_model;
    protected \Illuminate\Contracts\Cache\Repository|Store $cache;
    protected array $throttle_settings;

    public function __construct()
    {
        $this->eloquent_model = app(\App\Models\OsuAccount::class);
        $this->cache = app('cache.store');
        $this->throttle_settings = config('services.osu.throttle_settings');
    }

    public function getActive(): OsuAccount|null
    {
        $data = $this->getAllEloquent();
        $ids = array_column($data->toArray(), 'id');
        $active_ids = [];

        foreach ($ids as $id) {
            $item = $this
                ->cache
                ->tags('osu')
                ->get('ApiThrottle:Osu:'.$id);

            if (is_null($item)) {
                $active_ids[] += $id;
            } else {

                if ($item < $this->throttle_settings['attempt_count']) {
                    $active_ids[] += $id;
                }
            }
        }

        $active_account = null;

        if (!empty($active_ids)) {
            foreach ($data as $account) {
                if ($account->id == $active_ids[0]) {
                    $active_account = $account;
                }
            }
        }

        if ($active_account) {
            $proxy = new Proxy(
                $active_account->proxy_type,
                $active_account->proxy_host,
                $active_account->proxy_login,
                $active_account->proxy_password,
                $active_account->proxy_port
            );

            $active_account = new OsuAccount(
                $active_account->id,
                $active_account->created_at,
                $active_account->updated_at,
                $active_account->expires_in,
                $active_account->access_token,
                $active_account->refresh_token,
                $active_account->user_agent,
                $active_account->client_secret,
                $active_account->client_id,
                $proxy,
            );

            //86400
            $tokens_handler = new TokensHandler($active_account);
            $tokens_handler->checkAndUpdateAccessToken();
            $active_account = $tokens_handler->getAccount();
            $this->updateAccount($active_account);

            return $active_account;
        }

        return null;
    }

    public function getFirstAccountId(): int
    {
        return $this->eloquent_model->first(['id'])->id;
    }

    public function updateAccount(OsuAccount $account)
    {
        $accountDb = $this->eloquent_model->find($account->id);

        $accountDb->access_token = $account->access_token;
        $accountDb->refresh_token = $account->refresh_token;
        $accountDb->expires_in = $account->expires_in;
        $accountDb->update();
    }

    private function getAllEloquent()
    {
        return $this->eloquent_model->all([
            'id',
            'proxy_type',
            'proxy_host',
            'proxy_login',
            'proxy_password',
            'proxy_port',
            'access_token',
            'refresh_token',
            'expires_in',
            'user_agent',
            'client_secret',
            'client_id',
            'created_at',
            'updated_at',
        ]);
    }
}
