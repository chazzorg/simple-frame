<?php

/**
 * redis 配置
 */
return [
    'host'     => env('REDIS_HOST', '127.0.0.1'),
    'port'     => env('REDIS_PORT', 6379),
    'passwd'   => env('REDIS_PASSWORD', '123456'),
    'db'       => 0,
    'pconnect' => false
];
