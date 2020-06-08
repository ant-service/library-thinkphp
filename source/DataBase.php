<?php

namespace AntService\Src;

use AntService\Src\DataBase\StructSync;
use AntService\Src\Think\Database as ThinkDatabase;
use Exception;

class DataBase
{
    use ThinkDatabase, StructSync;

    public static function use(...$param)
    {
        $mode = array_shift($param);
        try {
            if (is_callable($mode)) return self::callable($mode, ...$param);
        } catch (Exception $e) {
            OutPut::error('USE_DATABASE_FAIL', $e->getMessage(), 500);
        }
        return new self;
    }

    public static function useTransaction(...$param)
    {
        $mode = array_shift($param);
        $thinkDb = self::getThinkDB();
        $thinkDb::startTrans();
        try {
            $result = $mode($thinkDb, ...$param);
            $thinkDb::commit();
        } catch (Exception $e) {
            $thinkDb::rollback();
            OutPut::error('USE_TRANSACTION_FAIL', $e->getMessage(), 500);
        }
        return $result;
    }

    private static function callable(callable $callback, ...$param)
    {
        return $callback(self::getThinkDB(), ...$param);
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
