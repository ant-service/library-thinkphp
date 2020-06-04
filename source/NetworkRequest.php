<?php

namespace AntService\Src;

use AntService\Src\Network\Basic;
use AntService\Src\Network\Header;
use AntService\Src\Network\Request;

class NetworkRequest
{
    use Basic, Header, Request {
        Header::add as addHeader;
        Header::set as setHeader;
        Header::getContent as getHeaderContent;
    }

    private static $curl = null;
    private static $formatType = null;
    private static $networkRequest = null;

    public static function instance()
    {
        if (self::$networkRequest == null) self::$networkRequest = new self;
        return self::$networkRequest;
    }

    public static function use(callable $callback = null)
    {
        self::initCurl();
        $instance = self::instance();
        if (is_callable($callback)) {
            $callback($instance);
            return $instance->sendRequest();
        }
        return $instance;
    }

    private static function initCurl()
    {
        self::$curl = curl_init();
        curl_setopt(self::$curl, CURLOPT_FOLLOWLOCATION, self::$isFollow);
        curl_setopt(self::$curl, CURLOPT_USERAGENT, self::$userAgent);
        curl_setopt(self::$curl, CURLOPT_AUTOREFERER, true);
        curl_setopt(self::$curl, CURLOPT_TIMEOUT, self::$timeOut);
        curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(self::$curl, CURLOPT_HEADER, true);
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(self::$curl, CURLOPT_SSL_VERIFYHOST, false);
        self::$cookie and curl_setopt(self::$curl, CURLOPT_COOKIE, self::$cookie);
        self::$referer and curl_setopt(self::$curl, CURLOPT_REFERER, self::$referer);
    }

    public static function formatResult($formatType = 'array')
    {
        self::$formatType = $formatType;
    }

    private static function sendRequest()
    {
        foreach (self::$requestData as $key => $value) {
            curl_setopt(self::$curl,  eval('return ' . $key . ';'), $value);
        }
        if (count(self::getHeaderContent()))
            curl_setopt(self::$curl, CURLOPT_HTTPHEADER, self::getHeaderContent());
        $content = curl_exec(self::$curl);
        $status = curl_getinfo(self::$curl, CURLINFO_HTTP_CODE);
        $error = curl_error(self::$curl);
        curl_close(self::$curl);
        $resultArr = explode(PHP_EOL . PHP_EOL, $content);
        list($headerInfo, $content) = array($resultArr[count($resultArr) - 2], $resultArr[count($resultArr) - 1]);
        foreach (explode(PHP_EOL, $headerInfo) as $header) {
            $headerArr = explode(':', $header);
            count($headerArr) == 2 and $headers[] = array($headerArr[0] => $headerArr[1]);
        }
        if (self::$formatType == 'array') {
            $content = DataType::convertArray($content);
        }
        return array(
            'status' => $status,
            'headers' => isset($headers) ? $headers : array(),
            'content' => $content,
            'error' => $error
        );
    }
}
