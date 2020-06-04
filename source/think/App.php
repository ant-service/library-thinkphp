<?php

namespace AntService\Src\Think;

use think\App as ThinkApp;

trait App
{
    private static $thinkApp = null;

    public static function getThinkApp()
    {
        if (self::$thinkApp == null) {
            self::$thinkApp = new ThinkApp();
            self::$thinkApp::setInstance(null);
        }
        return self::$thinkApp;
    }
}
