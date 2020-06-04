<?php

namespace AntService\Src\Think;

trait Request
{
    use App;

    private static $thinkRequest = null;

    public static function getThinkRequest()
    {
        if (self::$thinkRequest == null) {
            self::$thinkRequest = self::getThinkApp()->make('request', [], true);
        }
        return self::$thinkRequest;
    }
}
