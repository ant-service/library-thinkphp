<?php

namespace AntService\Src;

use AntService\Src\DataBase\StructSync;
use AntService\Src\Think\Database as ThinkDatabase;

class DataBase
{
    use ThinkDatabase, StructSync;

    public static function use(...$param)
    {
        $mode = array_shift($param);
        if (is_callable($mode)) return self::callable($mode, ...$param);
        return new self;
    }

    private static function callable(callable $callback, ...$param)
    {
        $cache = self::getThinkDB();
        return $callback($cache, ...$param);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getThinkDB()::$name(...$arguments);
    }

    public function __call($name, $arguments)
    {
        return self::getThinkDB()->$name(...$arguments);
    }
}
