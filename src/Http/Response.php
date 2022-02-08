<?php

namespace Chazz\Http;

use Chazz\Http\DataFormat\HtmlFormat;
use Chazz\Http\DataFormat\JsonFormat;
use Chazz\Http\DataFormat\JsonpFormat;
use Chazz\Http\DataFormat\XmlFormat;

class Response
{
    private static $instance;

    /**
     * @var int
     */
    private $responseCode = 200;

    /**
     * @var string
     */
    private $responseContentType = 'html';

    /**
     * @var string
     */
    private $responseBody = '';

    public function __construct() {}

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 设置头信息
     */
    public function sendHeader()
    {
        header("HTTP/1.1 " . $this->responseCode);
        header("Content-type: " . $this->ContentType() . ";charset=utf-8");
        header("Content-length: " . strlen($this->responseBody));
    }

    /**
     * 设置返回码
     */
    public function status($code)
    {
        $this->responseCode = $code;
        return $this;
    }

    /**
     * 设置类型
     */
    public function type($type)
    {
        $this->responseContentType = $type;
        return $this;
    }

    /**
     * 获取头部类型
     */
    public function ContentType()
    {
        switch ($this->responseContentType) {
            case 'html':
                return "text/html";
                break;
            case 'json':
                return "application/json";
                break;
            case 'xml':
                return "application/xml";
                break;
            case 'jsonp':
                return "application/json";
                break;
            default:
                return "text/html";
                break;
        }
    }

    /**
     * 输出
     */
    public function end($data = '')
    {
        $this->dataformat($data);
        $this->sendHeader();
        exit($this->responseBody);
    }

    /**
     * 跳转地址
     * @param $url
     */
    public function redirect($url)
    {
        header("location:$url");
        exit();
    }

    public function setResponseBody($body)
    {
        $this->responseBody = $body;
    }

    public function dataformat($data)
    {
        switch ($this->responseContentType) {
            case 'html':
                $this->responseBody = (new HtmlFormat($data))->format();
                break;
            case 'json':
                $this->responseBody = (new JsonFormat($data))->format();
                break;
            case 'xml':
                $this->responseBody = (new XmlFormat($data))->format();
                break;
            case 'jsonp':
                $this->responseBody = (new JsonpFormat($data))->format();
                break;
            default:
                $this->responseBody = $data;
                break;
        }
        return $this->responseBody;
    }

    /**
     * 渲染模板
     * @param null $file 为空时，
     * @param bool $param 传递数据
     * @return string
     */
    public function display($path, $param = array())
    {
        if (is_array($param)) {
            extract($param);
        }
        $path = config('app.view') . $path . '.php';
        if (!file_exists($path)) {
            $this->status(404);
            $this->end("模板不存在：" . $path);
        }
        ob_start();
        include $path;
    }
}
