<?php

return [
    'server-address' => env('REMOTE_SERVER_ADDRESS', ''),
    'server-uri'     => env('REMOTE_SERVER_URI', ''),
    'true-status'    => env('REMOTE_TRUE_STATUS_RESPONSE', 201),
    'false-status'   => env('REMOTE_FALSE_STATUS_RESPONSE', 209),
    'ttl'            => env('REMOTE_CACHE_TIME', 1800),
    'debug'          => env('REMOTE_DEBUG', false),
    'ssl_verify'     => env('REMOTE_SSL_VERIFY', false)
];
