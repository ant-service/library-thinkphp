<?php

namespace AntService\Src\Network;

trait Request
{
    private static $method = null;
    private static $requestData = array();

    public static function get($url, $param = array(), $prot = 80)
    {
        self::$requestData = array();
        if (count($param)) $url .= '?' . http_build_query($param);
        self::$requestData['CURLOPT_URL'] = $url;
        self::$requestData['CURLOPT_PORT'] = $prot;
    }

    public static function post($url, $data, $prot = 80)
    {
        self::$requestData = array();
        self::$requestData['CURLOPT_URL'] = $url;
        self::$requestData['CURLOPT_POST'] = true;
        self::$requestData['CURLOPT_PORT'] = $prot;
        self::$requestData['CURLOPT_POSTFIELDS'] = $data;
    }

    public static function patch($url, $data, $prot = 80)
    {
        self::$requestData = array();
        self::$requestData['CURLOPT_CUSTOMREQUEST'] = 'PATCH';
        self::$requestData['CURLOPT_URL'] =  $url;
        self::$requestData['CURLOPT_PORT'] = $prot;
        self::$requestData['CURLOPT_POSTFIELDS'] = $data;
    }

    public static function put($url, $data, $prot = 80)
    {
        self::$requestData = array();
        self::$requestData['CURLOPT_CUSTOMREQUEST'] = 'PUT';
        self::$requestData['CURLOPT_URL'] =  $url;
        self::$requestData['CURLOPT_PORT'] = $prot;
        self::$requestData['CURLOPT_POSTFIELDS'] = $data;
    }

    public static function delete($url, $data, $prot = 80)
    {
        self::$requestData = array();
        self::$requestData['CURLOPT_CUSTOMREQUEST'] = 'DELETE';
        self::$requestData['CURLOPT_URL'] =  $url;
        self::$requestData['CURLOPT_PORT'] = $prot;
        self::$requestData['CURLOPT_POSTFIELDS'] = $data;
    }
}
