<?php

namespace App\Services\Osu\Api;

use App\Contracts\Services\Api\ApiThrottle;
use Illuminate\Contracts\Cache\Store;

class Throttle implements ApiThrottle
{
    /**
     * Настройки тротлинга.
     */
    protected array $throttle_settings;
    protected int $account_id;

    /**
     * Кеш.
     */
    protected \Illuminate\Contracts\Cache\Repository|Store $cache;

    public function __construct(array $throttle_settings)
    {
        $this->throttle_settings = $throttle_settings;
        $this->cache = app('cache.store');
    }

    /**
     * Проверка разрешения на обращение к api.
     * Если true, то тротлинг активен, в ином случае будет возвращено false.
     * @return bool
     */
    public function check(): bool
    {
        $key = $this->getKey();

        if ($this->cache->tags('osu')->has($key)) {

            if ($this->cache->tags('osu')->get($key.':FailTimeOut')) {
                return true;
            }

            /*
             * Количество отправленных запросов к api не привышает заданное количество.
             */
            if ($this->cache->tags('osu')->get($key) < $this->throttle_settings['attempt_count']) {
                return false;
            } else {

                /*
                 * Время блокировки подошло к концу.
                 */
                if ($this->cache->tags('osu')->get($key.':TimeOut') + $this->throttle_settings['time_out'] < time()) {
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

        if ($this->cache->tags('osu')->has($key)) {

            $this->cache->tags('osu')->increment($key);

        } else {
            $this->cache->tags('osu')->put($key, 1, $this->throttle_settings['time_out']);
            $this->cache->tags('osu')->put($key.':TimeOut', time(), $this->throttle_settings['time_out']);
        }
    }

    public function getTimeOut(): int
    {
        $key = $this->getKey();

        if ($this->cache->tags('osu')->has($key)) {
            $count = $this->getCount();
            $attemptCount = $this->throttle_settings['attempt_count'];

            /*
             * Троттлинг активен.
             */
            if ($count > $attemptCount) {
                $failTimeOutKey = $key.':FailTimeOut';

                if ($this->cache->tags('osu')->has($failTimeOutKey)) {
                    /**
                     * Увеличение времени блокировки для последующих задач.
                     */
                    $multiplier = ceil($count / $attemptCount);
                    $timeOut = $this->cache->tags('osu')->get($failTimeOutKey) + ($multiplier * $this->throttle_settings['time_out']) - time();
                } else {
                    /**
                     * Первое нарушение, устанавливаем время блокировки.
                     */
                    $timeOut = $this->cache->tags('osu')->get($key.':TimeOut') + $this->throttle_settings['time_out'] - time();
                    $this->cache->tags('osu')->put($failTimeOutKey, time() + $timeOut, $timeOut);
                }

                return $timeOut;
            }

            /*
             * Если троттлинг не активен, возвращаем время до окончания текущего TimeOut
             */
            return $this->cache->tags('osu')->get($key.':TimeOut') + $this->throttle_settings['time_out'] - time();
        }

        return 0;
    }

    protected function getCount(): int
    {
        $key = $this->getKey();

        return $this->cache->tags('osu')->get($key);
    }

    /**
     * Формирование ключа.
     */
    protected function getKey(): string
    {
        return 'ApiThrottle:Osu:'.$this->account_id;
    }

    public function setAccountId(int $id): void
    {
        $this->account_id = $id;
    }
}
