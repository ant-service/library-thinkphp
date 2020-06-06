<?php

namespace AntService\Src;

use AntService\Src\Think\Request as ThinkRequest;

class Request
{
    use ThinkRequest;

    public static function rootDirectory()
    {
        $rootDir = $_SERVER['DOCUMENT_ROOT'];
        if ($rootDir != '') $rootDir .= '/';
        return str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $rootDir);
    }

    /**
     * 获取当前请求的参数
     * @access public
     * @param  string|array $name 变量名
     * @param  mixed        $default 默认值
     * @param  string|array $filter 过滤方法
     * @return mixed
     */
    public static function param($name = '', $default = null, $filter = '')
    {
        return self::getThinkRequest()->param($name, $default, $filter);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getThinkRequest()::$name(...$arguments);
    }

    public function __call($name, $arguments)
    {
        return self::getThinkRequest()->$name(...$arguments);
    }
}
