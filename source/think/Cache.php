<?php

namespace AntService\Src\Think;

use AntService\Src\Config;

trait Cache
{
    use App;

    private static $thinkCache = null;

    public static function getThinkCache()
    {
        if (self::$thinkCache == null) {
            $thinkApp = self::getThinkApp();
            $thinkApp->config->set([
                'default' => Config::read('think.default.cache'),
                'stores' => Config::read('think.cache')
            ], 'cache');
            self::$thinkCache = $thinkApp->make('cache', [], true);
        }
        return self::$thinkCache;
    }
}