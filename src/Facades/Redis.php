<?php
namespace Chazz\Facades;

use Chazz\Lib\Facade;

class Redis extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}