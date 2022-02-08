<?php

namespace Chazz\Http\DataFormat;

class HtmlFormat extends BaseFormat
{
    public function format()
    {
        return is_array($this->data) ? var_export($this->data) : $this->data;
    }
}
