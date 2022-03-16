<?php

return [
    'server-address' => env('REMOTE_SERVER_ADDRESS', ''),
    'server-uri'     => env('REMOTE_SERVER_URI', ''),
    'true-status'    => env('REMOTE_TRUE_STATUS_RESPONSE', 201),
    'false-status'   => env('REMOTE_FALSE_STATUS_RESPONSE', 209),
    'debug'          => env('REMOTE_DEBUG', false),
];
