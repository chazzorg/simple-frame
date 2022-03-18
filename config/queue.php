<?php

/**
 * queue 配置
 */
return [
    'default'  => 'redis',
    'redis' => [
        'driver'        => 'redis',
        'name'          => 'redis',
        'serialize'     => true,
        'serializer'    => 'serialize', //data serializer like 'serialize' 'json_encode'
        'deserializer'  => 'unserialize', // data deserializer like 'unserialize' 'json_decode'
    ]
];
