<?php

namespace AntService\Src;

use AntService\Src\Think\Validate as ThinkValidate;
use AntService\Src\Validate\Rule;

class Validate
{
    use ThinkValidate, Rule;

    private static $paramKeys = array();

    private static $paramValue = '';

    /**
     * 设置验证参数
     * @param string $key 参数名
     * @return Validate
     */
    public static function setParam(string $key, string $name): Validate
    {
        list(self::$paramKey, self::$paramName, self::$paramValue, self::$paramKeys[]) = array($key, $name, Request::param($key), $key);
        return new self;
    }

    /**
     * 验证参数
     * @param string $ruleName 验证类型名
     * @param string $msg 未通过提示信息
     * @return Validate
     */
    private static function ValidateParam(string $ruleName, string $msg): Validate
    {
        $validate = self::getThinkValidate()->rule([self::$paramKey => $ruleName])->message([self::$paramKey . '.' . DataType::convertArray($ruleName, ':')[0] => $msg]);
        if (!$validate->check(Request::param())) {
            OutPut::error('Validate_PARAM_FAIL', $validate->getError(), 400);
        }
        return new self;
    }

    /**
     * 返回参数值
     * @return any
     */
    public static function value()
    {
        return self::$paramValue;
    }

    /**
     * 返回保留字段
     * @param array ...$keys 字段名
     * @return array 保留字段
     */
    public static function keep(string ...$keys): array
    {
        $params = array();
        foreach ($keys as $key) {
            $params[$key] = Request::param($key);
        }
        return $params;
    }

    /**
     * 提取有效参数
     * @param array ...$keys 删除的参数名
     * @return array 有效参数
     */
    public static function draw(string ...$keys)
    {
        $params = array();
        foreach (self::$paramKeys as $key) {
            if (in_array($key, $keys)) continue;
            if (Request::param($key) != '') $params[$key] = Request::param($key);
        }
        return $params;
    }
}
