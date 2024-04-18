<?php

namespace App\Models;

use App\Base\Enums\ProxyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OsuAccount extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = [
        'proxy_type',
        'proxy_host',
        'proxy_login',
        'proxy_password',
        'proxy_port',
        'refresh_token',
        'access_token',
        'expires_in',
        'user_agent',
        'client_secret',
        'client_id',
    ];

    protected $casts = [
        'proxy_type' => ProxyType::class,
    ];
}
