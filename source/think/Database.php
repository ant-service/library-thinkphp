<?php

namespace AntService\Src\Think;

use AntService\Src\Config;

trait Database
{
    use App;

    private static $thinkDataBase = null;

    public static function getThinkDB()
    {
        if (self::$thinkDataBase == null || $_SERVER['is_init_module']) {
            $thinkApp = self::getThinkApp($_SERVER['is_init_module']);
            self::$thinkDataBase = $thinkApp->make('think\facade\Db', [], true);
            self::$thinkDataBase::setConfig([
                'default' => Config::read('think.default.database'),
                'connections' => Config::read('think.database')
            ]);
        }
        return self::$thinkDataBase;
    }
}
