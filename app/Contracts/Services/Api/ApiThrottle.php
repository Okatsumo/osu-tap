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

    /**
     * Проверка наличия тротлинга, и, в случае если его нет, добавление в него 1 попытки
     * если true, то тротлинг активен, в ином случае будет возвращено false
     */
    public function checkAndAddCount(): bool;
}
