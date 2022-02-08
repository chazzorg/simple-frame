<?php

namespace Chazz\Controllers;

class Controller
{
    public function __set($name, $object)
    {
        $this->$name = $object;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
