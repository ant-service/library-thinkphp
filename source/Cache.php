<?php

namespace AntService\Src;

use AntService\Src\Think\Cache as ThinkCache;

class Cache
{
    use ThinkCache;

    /**
     * 使用缓存
     * @param mixed ...$param 传入参数
     * set $key,$value,$expire
     * get $key
     * @return mixed 设置结果(bool)/获取结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function use(...$param)
    {
        $mode = array_shift($param);
        if (is_callable($mode)) return self::callable($mode, ...$param);
        if ($mode === 'get') return self::get($param[0]);
        if ($mode === 'get_expire_time') return self::getExpireTime($param[0]);
        if ($mode === 'set') return self::set($param[0], $param[1], $param[2], $param[3]);
        return new self;
    }

    private static function callable(callable $callback, ...$param)
    {
        $cache = self::getThinkCache();
        return $callback($cache, ...$param);
    }

    public static function get($key, $defaultResult = false)
    {
        if ($key === null) return $defaultResult;
        $result = self::getThinkCache()->get($key, $defaultResult);
        if ($result === $defaultResult) return $result;
        return $result['value'];
    }

    public static function getExpireTime($key, $defaultResult = false)
    {
        if ($key === null) return $defaultResult;
        $result = self::getThinkCache()->get($key, $defaultResult);
        if ($result === $defaultResult) return $result;
        return $result['expire'] - time();
    }

    public static function set($key, $value, $expire)
    {
        return self::getThinkCache()->set($key, ['value' => $value, 'expire' => time() + $expire], $expire);
    }

    public static function remove($key)
    {
        return self::getThinkCache()->delete($key);
    }
}
