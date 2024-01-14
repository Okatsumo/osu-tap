<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'osu' => [
        'base_url' => 'https://osu.ppy.sh/api/v2/',
        'auth_url' => env('OSU_AUTH_URL', 'https://osu.ppy.sh/oauth/authorize'),
        'client_id' => env('OSU_CLIENT_ID', ''),
        'client_secret' => env('OSU_CLIENT_SECRET', ''),
        'scopes' => env('OSU_SCOPES', 'public'),
        'token' => env('OSU_TOKEN'),
        'throttle_settings' => [
            'attempt_count' => 190,
            'time_out' => 60,
        ]
    ]
];
