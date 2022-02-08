<?php

namespace Chazz\Http;

class Request
{
    private static $instance;
    private $server;
    private $header;
    private $request;
    private $post;
    private $get;
    private $cookie;
    private $files;
    private $rawContent;

    private function __construct()
    {
        $this->server       = $_SERVER;
        $this->header       = getallheaders();
        $this->request      = $_REQUEST;
        $this->cookie       = $_COOKIE;
        $this->get          = $_GET;
        $this->files        = $_FILES;
        $this->post         = $_POST;
        $this->rawContent   = file_get_contents('php://input');
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function header($name = null, $default = null)
    {
        if ($name === null) {
            return $this->header;
        }
        if (isset($this->header[$name])) {
            return $this->header[$name];
        }
        $name = str_replace('_', '-', $name);
        if (isset($this->header[$name])) {
            return $this->header[$name];
        }
        return $default;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function server($name = null, $default = null)
    {
        if ($name === null) {
            return $this->server;
        }
        if (isset($this->server[$name])) {
            return $this->server[$name];
        }
        $name = strtoupper($name);
        if (isset($this->server[$name])) {
            return $this->server[$name];
        }
        $name = str_replace('_', '-', $name);
        if (isset($this->server[$name])) {
            return $this->server[$name];
        }
        return $default;
    }

    /**
     * @return string|null
     */
    public function rawContent()
    {
        return $this->rawContent;
    }

    /**
     * @return string|null
     */
    public function ip()
    {
        return $this->server('REMOTE_ADDR');
    }

    /**
     * @return mixed|null
     */
    public function userAgent()
    {
        return $this->header('User-Agent');
    }

    /**
     * @return string
     */
    public function uri()
    {
        $path  = urldecode($this->server('REQUEST_URI'));
        $paths = explode('?', $path);
        return '/' . trim($paths[0], '/');
    }

    protected function getFromArr($arr, $key, $default = null)
    {
        if ($key === null) {
            return $arr;
        }

        if (isset($arr[$key])) {
            return $arr[$key];
        } else if (strpos($key, '.') !== false) {
            $keys = explode('.', $key);
            foreach ($keys as $v) {
                if (isset($arr[$v])) {
                    $arr = $arr[$v];
                } else {
                    return $default;
                }
            }
            return $arr;
        } else {
            return $default;
        }
    }

    /**
     * @param $key
     * @param $default
     * @return mixed|null
     */
    public function get($key = null, $default = null)
    {
        return $this->getFromArr($this->get, $key, $default);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function post($key = null, $default = null)
    {
        return $this->getFromArr($this->post, $key, $default);
    }

    /**
     * @param int $i
     * @return mixed|null
     */
    public function arg($i = null, $default = null)
    {
        global $argv;
        return $this->getFromArr($argv, $i, $default);
    }


    /**
     * @param $key
     * @return mixed|null
     */
    public function res($key = null, $default = null)
    {
        return $this->getFromArr($this->request, $key, $default);
    }


    /**
     * @param $key
     * @return mixed|null
     */
    public function cookie($key = null, $default = null)
    {
        return $this->getFromArr($this->cookie, $key, $default);
    }

    /**
     * @return string
     */
    public function input()
    {
        return $this->rawContent;
    }

    /**
     * @return array
     */
    public function json()
    {
        return json_decode($this->input(), true);
    }

    /**
     * @return array
     */
    public function file()
    {
        $files = [];
        foreach ($this->files as $name => $fs) {
            $keys = array_keys($fs);
            if (is_array($fs[$keys[0]])) {
                foreach ($keys as $k => $v) {
                    foreach ($fs[$v] as $i => $val) {
                        $files[$name][$i][$v] = $val;
                    }
                }
            } else {
                $files[$name] = $fs;
            }
        }
        return $files;
    }

    /**
     * @return string
     */
    public function method()
    {
        return strtolower($this->server('REQUEST_METHOD'));
    }

    /**
     * @return bool
     */
    public function isJson()
    {
        if ($this->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest' || strpos($this->header('Accept'), '/json') !== false) {
            return true;
        } else {
            return false;
        }
    }
}
