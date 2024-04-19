<?php

namespace App\Base\Dto;

use App\Base\Enums\ProxyType;

final class Proxy
{
    public function __construct(
        public ProxyType $type,
        public string $host,
        public string $login,
        public string $password,
        public int $port,
    ) {}
}
