<?php

namespace AntService\Src\Network;

trait Basic
{
    private static $isFollow = false;
    private static $userAgent = false;
    private static $timeOut = 60;
    private static $cookie = '';
    private static $referer = '';

    public static function openFollow()
    {
        self::$isFollow = true;
    }

    public static function setUserAgent(string $value = 'default')
    {
        self::$userAgent = $value;
        if ($value == 'default') self::$userAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    public static function setTimeout(int $sec = 60)
    {
        self::$timeOut = $sec;
    }

    public static function setCookie(array $cookies)
    {
        $cookieArr = array();
        foreach ($cookies as $key => $value) {
            $cookieArr[] = $key . '=' . $value;
        }
        return implode('; ', $cookieArr);
    }

    public static function setReferer($referer = '')
    {
        self::$referer = $referer;
        return new self;
    }
}
