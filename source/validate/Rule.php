<?php


namespace AntService\Src\Validate;

use AntService\Src\DataType;

trait Rule
{
    private static $paramKey = '';
    private static $paramName = '';

    /**
     * 验证类型-必填内容
     * @param string $msg 自定义提示信息
     * @return Validate
     */
    function require(string $msg = ''): self
    {
        return self::ValidateParam(
            __FUNCTION__,
            self::$paramName . '[' . self::$paramKey . ']' . ($msg == '' ? '不允许为空' : $msg)
        );
    }

    /**
     * 验证类型-数字/字母/下划线
     * @param string $msg 自定义提示信息
     * @return Validate
     */
    function alphaDash(string $msg = ''): self
    {
        return self::ValidateParam(
            __FUNCTION__,
            self::$paramName . '[' . self::$paramKey . ']' . ($msg == '' ? '只允许数字或字母或下划线' : $msg)
        );
    }

    /**
     * 验证类型-数字
     * @param string $msg 自定义提示信息
     * @return Validate
     */
    function number(string $msg = ''): self
    {
        return self::ValidateParam(
            __FUNCTION__,
            self::$paramName . '[' . self::$paramKey . ']' . ($msg == '' ? '只允许数字' : $msg)
        );
    }

    /**
     * 验证类型-整型
     * @param string $msg 自定义提示信息
     * @return Validate
     */
    function integer(string $msg = ''): self
    {
        return self::ValidateParam(
            __FUNCTION__,
            self::$paramName . '[' . self::$paramKey . ']' . ($msg == '' ? '只允许数字' : $msg)
        );
    }

    /**
     * 验证类型-浮点型
     * @param string $msg 自定义提示信息
     * @return Validate
     */
    function float(string $msg = ''): self
    {
        return self::ValidateParam(
            __FUNCTION__,
            self::$paramName . '[' . self::$paramKey . ']' . ($msg == '' ? '只允许数字' : $msg)
        );
    }

    /**
     * 验证类型-在..之间
     * @param string $vals 可通过内容,例1,2,3 参数必须为123
     * @param string ...$name 对应内容,例$vals = '123' $name 则需要传入1对应名称,2对应名称,3对应名称
     * @return void
     */
    function in(string $vals, string ...$name): self
    {
        $msg = '只能为[';
        foreach (DataType::convertArray($vals, ',') as $key => $val) {
            $msg .= $val . ' ' . ($name[$key] ?? '') . ';';
        }
        $msg .= ']';
        return self::ValidateParam(
            __FUNCTION__ . ':' . $vals,
            self::$paramName . '[' . self::$paramKey . ']' . ($msg == '' ? '只允许数字或字母或下划线' : $msg)
        );
    }

    /**
     * 验证长度
     * @param integer $minLen 最小长度 / 限制长度
     * @param integer $maxLen 最大长度
     * @param string $msg 自定义返回值
     * @return void
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function length($minLen, $maxLen = 0, $msg = ''): self
    {
        if ($maxLen == 0) $maxLen = $minLen;
        if ($msg == '') {
            if ($maxLen == $minLen) {
                $msg = '长度只能为：' . $minLen;
            } else {
                $msg = '长度必须大于' . $minLen . '并且小于' . $maxLen;
            }
        }
        return self::ValidateParam(
            __FUNCTION__ . ':' . $minLen . ',' . $maxLen,
            self::$paramName . '[' . self::$paramKey . ']' . $msg
        );
    }
}
