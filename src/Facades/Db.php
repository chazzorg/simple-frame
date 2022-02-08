<?php
namespace Chazz\Facades;

use Chazz\Lib\Facade;

class Db extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}