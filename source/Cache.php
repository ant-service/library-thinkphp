<?php

namespace AntService\Src;

use AntService\Src\Think\Cache as ThinkCache;

class Cache
{
    use ThinkCache;

    /**
     * 使用缓存
     * @param mixed ...$param 传入参数
     * set $key,$value,$expires
     * get $key
     * @return mixed 设置结果(bool)/获取结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function use(...$param)
    {
        $mode = array_shift($param);
        if (is_callable($mode)) return self::callable($mode, ...$param);
        if ($mode === 'get') return self::getThinkCache()->get($param[0]);
        if ($mode === 'set') return self::getThinkCache()->set($param[0], $param[1], $param[2], $param[3]);
        return new self;
    }

    private static function callable(callable $callback, ...$param)
    {
        $cache = self::getThinkCache();
        return $callback($cache, ...$param);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getThinkCache()::$name(...$arguments);
    }

    public function __call($name, $arguments)
    {
        return self::getThinkCache()->$name(...$arguments);
    }
}
