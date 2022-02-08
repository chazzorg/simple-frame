<?php

#框架全局助手函数

/**
 * 快捷调试打印
 * @param ...$args
 * @return mixed
 */
if (function_exists('dd') === false) {
    function dd(...$args)
    {
        foreach ($args as $x) {
            var_dump($x);
        }
        exit;
    }
}

/**
 * 获取环境配置
 * @param string $name        参数名
 * @param null   $default     错误默认返回值
 * 
 * @return mixed|null
 */
if (function_exists('env') === false) {
    function env($name = null, $default = null)
    {
        if ($name) {
            return $_ENV[$name] ?? $default;
        } else {
            return $_ENV ?: [];
        }
    }
}

/**
 * 获取应用配置参数
 * @param      $name        参数名 格式：文件名.参数名
 * @param null $default     错误默认返回值
 *
 * @return mixed|null
 */
if (function_exists('config') === false) {
    function config($name, $default = null)
    {
        return Chazz\Lib\Config::getInstance()->get($name, $default);
    }
}

/**
 * UUID
 * @param  bool     base62
 * @return string   UUID
 */
if (function_exists('uuid') === false) {
    function uuid($base62 = true)
    {
        $str = uniqid('', true);
        $arr = explode('.', $str);
        $str = $arr[0] . base_convert($arr[1], 10, 16);
        $len = 32;
        while (strlen($str) <= $len) {
            $str .= bin2hex(random_bytes(4));
        }
        $str = substr($str, 0, $len);
        if ($base62) {
            $str = str_replace(['+', '/', '='], '', base64_encode(hex2bin($str)));
        }
        return $str;
    }
}

/**
 * 毫秒级时间戳
 * @return string
 */
if (function_exists('microsecond') === false) {
    function microsecond()
    {
        $time = explode(" ", microtime());
        $time = $time[1] . ($time[0] * 1000);
        $time = explode(".", $time);
        $time = $time[0];
        return $time;
    }
}

/**
 * 加密
 * @param string $str    要加密的数据
 * @param string $aes_key AES秘钥
 * @return bool|string   加密后的数据
 */
if (function_exists('encrypt') === false) {
    function encrypt($str, $aes_key)
    {
        $data = openssl_encrypt($str, 'AES-128-ECB', $aes_key, OPENSSL_RAW_DATA);
        $data = base64_encode($data);
        return $data;
    }
}

/**
 * 解密
 * @param string $str     要解密的数据
 * @param string $aes_key AES秘钥
 * @return string         解密后的数据
 */
if (function_exists('decrypt') === false) {
    function decrypt($str, $aes_key)
    {
        $decrypted = openssl_decrypt(base64_decode($str), 'AES-128-ECB', $aes_key, OPENSSL_RAW_DATA);
        return $decrypted;
    }
}

/**
 * 构建Http请求
 * @param string $url     请求地址
 * @param string $data    请求数据
 * @param string $type    请求类型
 * @param string $referer 伪造referer
 * @return string         请求结果
 */
if (function_exists('Http') === false) {
    function Http($url, $data, $type = "http", $referer = '')
    {
        $curl = curl_init();
        if ($type == "json") {
            $headers = array("Content-type: application/json;charset=UTF-8");
            $data = json_encode($data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}

/**
 * 将命名转换为驼峰式命名
 * @param string $str     需要转换的字符串
 * @param string $ucfirst 首字母大写
 * @param string $symbol  分割符号
 * @return string         新字符串
 */
if (function_exists('convertname') === false) {
    function convertname($str, $ucfirst = true, $symbol = '_')
    {
        $str = ucwords(str_replace($symbol, ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }
}
