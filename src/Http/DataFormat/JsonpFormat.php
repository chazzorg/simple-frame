<?php

namespace Chazz\Http\DataFormat;

class JsonpFormat extends BaseFormat
{
    public function format()
    {
        return sprintf('%s(%s)', 'callback', json_encode($this->data));
    }
}