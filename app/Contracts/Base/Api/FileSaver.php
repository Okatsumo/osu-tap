<?php

namespace App\Contracts\Base\Api;

use App\Exceptions\OperationError;
use GuzzleHttp\Exception\GuzzleException;

interface FileSaver
{
    /**
     * @throws GuzzleException
     * @throws OperationError
     */
    public function save(string $url, string $path, string $name): void;

    public function setDisk(string $name): void;
}
