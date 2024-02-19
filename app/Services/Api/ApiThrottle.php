<?php

namespace App\Services\Api;

use \App\Contracts\Services\Api\ApiThrottle as ApiThrottleContract;
use Illuminate\Contracts\Cache\Store;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

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
    protected \Illuminate\Contracts\Cache\Repository|Store $cache;

    public function __construct(string $api_name, array $throttle_settings)
    {
        $this->api_name = $api_name;
        $this->throttle_settings = $throttle_settings;
        $this->cache = app('cache.store');
    }

    /**
     * Проверка разрешения на обращение к api.
     * Если true, то тротлинг активен, в ином случае будет возвращено false
     * @return bool
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     * @throws NotFoundExceptionInterface
     */
    public function check(): bool
    {
        $key = $this->getKey();

        if ($this->cache->has($key)) {

            if ($this->cache->get($key.':FailTimeOut')) {
                return true;
            }

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

    /**
     * @throws InvalidArgumentException
     */
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

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getTimeOut(): int
    {
        $key = $this->getKey();

        if ($this->cache->has($key)) {
            $count = $this->getCount();
            $attemptCount = $this->throttle_settings['attempt_count'];

            /**
             * Троттлинг активен.
             */
            if ($count > $attemptCount) {
                $failTimeOutKey = $key.':FailTimeOut';

                if ($this->cache->has($failTimeOutKey)) {
                    /**
                     * Увеличение времени блокировки для последующих задач
                     */
                    $multiplier = ceil($count / $attemptCount);
                    $timeOut = $this->cache->get($failTimeOutKey) + ($multiplier * $this->throttle_settings['time_out']) - time();
                } else {
                    /**
                     * Первое нарушение, устанавливаем время блокировки
                     */
                    $timeOut = $this->cache->get($key.':TimeOut') + $this->throttle_settings['time_out'] - time();
                    $this->cache->put($failTimeOutKey, time() + $timeOut, $timeOut);
                }

                return $timeOut;
            }

            /**
             * Если троттлинг не активен, возвращаем время до окончания текущего TimeOut
             */
            return $this->cache->get($key.':TimeOut') + $this->throttle_settings['time_out'] - time();
        }

        return 0;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function getCount(): int
    {
        $key = $this->getKey();

        return $this->cache->get($key);
    }

    /**
     * Формирование ключа.
     */
    protected function getKey(): string
    {
        return 'ApiThrottle:'.$this->api_name;
    }
}
