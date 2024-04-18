<?php

namespace App\Base\Enums;

enum ProxyType: string
{
    case http = 'http';
    case https = 'https';
}
