<?php

namespace AntService\Src\Network;

trait Header
{
    private static $headers = array();

    /**
     * 追加header
     * @param mixed ...$param 自定义参数
     * @example add('key','value') 单一追加 key键,value值
     * @example add(['key' => 'value']) 批量追加 key键,value值
     * @return self
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function add(...$param): self
    {
        foreach ($param as $key => $value) {
            if (is_string($value) && is_string($param[$key + 1])) {
                self::$headers[self::formatKey($value)] = $param[$key + 1];
                break;
            }
            if (is_array($value)) {
                foreach ($value as $k => $val) {
                    if (is_string($val)) {
                        self::$headers[self::formatKey($k)] = $val;
                    }
                }
            }
        }
        return self::instance();
    }

    /**
     * 设置Header,覆盖设置
     * @param array $param set(['key' => 'value'])批量追加 key键,value值
     * @return self
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function set(array $param = array()): self
    {
        self::$headers = array();
        foreach ($param as $key => $value) {
            self::$headers[self::formatKey($key)] = $value;
        }
        return self::instance();
    }

    /**
     * 获取最终结果
     * @return array
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function getContent(): array
    {
        $headers = array();
        foreach (self::$headers as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        return $headers;
    }

    /**
     * 格式化Header Key
     * @param string $key
     * @return string
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    private static function formatKey($key): string
    {
        $key = str_replace(['_'], ['-'], $key);
        $key = strtolower($key);
        $keyArr = explode('-', $key);
        foreach ($keyArr as $k => $v) {
            $keyArr[$k] = ucfirst($v);
        }
        return implode('-', $keyArr);
    }
}
