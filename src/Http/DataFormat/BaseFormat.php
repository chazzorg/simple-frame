<?php

namespace Chazz\Http\DataFormat;

abstract class BaseFormat
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    abstract public function format();
}
