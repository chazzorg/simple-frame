<?php
namespace Chazz\Facades;

use Chazz\Lib\Facade;

class Request extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'request';
    }
}