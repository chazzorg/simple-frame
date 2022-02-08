<?php

namespace Chazz\Http\DataFormat;

class JsonFormat extends BaseFormat
{
    public function format()
    {
        return json_encode($this->data);
    }
}