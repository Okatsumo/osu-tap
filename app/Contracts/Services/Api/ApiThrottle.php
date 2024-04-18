<?php

namespace App\Contracts\Services\Api;

interface ApiThrottle
{

    /**
     * Проверка разрешения на обращение к api.
     * Если true, то тротлинг активен, в ином случае будет возвращено false
     */
    public function check(): bool;

    /**
     * Добавить кол-во попыток обращения к api
     */
    public function addCount(): void;

    /**
     * Получение таймаута
     */
    public function getTimeOut(): int;
}
