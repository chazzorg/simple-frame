<?php

namespace Chazz\Http\DataFormat;

class XmlFormat extends BaseFormat
{
    public function format()
    {
        if (!is_array($this->data))
            $this->data = (array)($this->data);
        return $this->arrayToXml($this->data);
    }

    private function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . $this->arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}
