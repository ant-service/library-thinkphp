<?php

namespace AntService\Src\Think;

trait Validate
{
    use App;

    private static $thinkValidate = null;

    public static function getThinkValidate()
    {
        if (self::$thinkValidate == null) {
            self::$thinkValidate = self::getThinkApp()->make('validate', [], true);
        }
        return self::$thinkValidate;
    }
}
