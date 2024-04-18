<?php

namespace App\Services\Osu\Dto;

use App\Base\Dto\AccountTokensDto;
use App\Base\Dto\Proxy;
use Illuminate\Support\Carbon;

final class OsuAccount
{
    public function __construct(
        public int    $id,
        public Carbon $updated_at,
        public Carbon $created_at,
        public int    $expires_in,
        public string $access_token,
        public string $refresh_token,
        public string $user_agent,
        public string $client_secret,
        public string $client_id,
        public Proxy  $proxy,
    ){}
}
