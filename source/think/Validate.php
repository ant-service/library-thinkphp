<?php

namespace AntService\Src\Think;

use AntService\Src\Config;

trait Validate
{
    use App;

    private static $thinkValidate = null;

    public static function getThinkValidate()
    {
        if (self::$thinkValidate == null) {
            $thinkApp = self::getThinkApp();
            $thinkApp->config->set(array_merge(['default_lang' => Config::read('think.default.lang')], Config::read('think.lang')), 'lang');
            self::$thinkValidate = $thinkApp->make('validate', [], true);
            self::$thinkValidate->setLang($thinkApp->make('lang', [], true));
        }
        return self::$thinkValidate;
    }
}

