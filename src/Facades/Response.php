<?php
namespace Chazz\Facades;

use Chazz\Lib\Facade;

class Response extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'response';
    }
}