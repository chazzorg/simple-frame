<?php

/**
 * 静态代理
 */
return [
    'db'        => Chazz\Database\Model::class,
    'redis'     => Chazz\Cache\Redis::class,
    'request'   => Chazz\Http\Request::class,
    'response'  => Chazz\Http\Response::class,
];
