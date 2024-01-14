<?php

namespace App\Services\Api;

use \App\Contracts\Services\Api\ApiThrottle as ApiThrottleContract;

class ApiThrottle implements ApiThrottleContract
{
    protected string $api_name;

    /**
     * Настройки тротлинга.
     */
    protected array $throttle_settings;

    /**
     * Кеш.
     */
    protected \Illuminate\Contracts\Cache\Repository $cache;


    public function __construct(string $api_name, array $throttle_settings)
    {
        $this->api_name = $api_name;
        $this->throttle_settings = $throttle_settings;
        $this->cache = app('cache.store');
    }

    /**
     * Проверка разрешения на обращение к api.
     * Если true, то тротлинг активен, в ином случае будет возвращено false
     */
    public function check(): bool
    {
        $key = $this->getKey();

        if ($this->cache->has($key)) {

            /**
             * Количество отправленных запросов к api не привышает заданное количество.
             */
            if ($this->cache->get($key) < $this->throttle_settings['attempt_count']) {
                return false;
            } else {

                /**
                 * Время блокировки подошло к концу.
                 */
                if ($this->cache->get($key.':TimeOut') + $this->throttle_settings['time_out'] < time()) {
                    return false;
                } else {
                    return true;
                }

            }

        }

        return false;
    }

    public function addCount(): void
    {
        $key = $this->getKey();

        if ($this->cache->has($key)) {

            $this->cache->increment($key);

        } else {
            $this->cache->put($key, 1, $this->throttle_settings['time_out']);
            $this->cache->put($key.':TimeOut', time(), $this->throttle_settings['time_out']);
        }
    }

    public function getTimeOut(): int
    {
        $key = $this->getKey();

        if ($this->cache->has($key)) {
            return $this->cache->get($key.':TimeOut') + $this->throttle_settings['time_out'] - time();
        } else {
            return 0;
        }

    }

    /**
     * Формирование ключа.
     */
    protected function getKey(): string
    {
        return 'ApiThrottle:'.$this->api_name;
    }

    /**
     * Проверка наличия тротлинга, и, в случае если его нет, добавление в него 1 попытки
     * если true, то тротлинг активен, в ином случае будет возвращено false
     */
    public function checkAndAddCount(): bool
    {
        if ($this->check()) {
            return true;
        }

        $this->addCount();
        return false;
    }
}
