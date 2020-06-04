<?php

namespace AntService\Src\File;

trait Directory
{
    public static function isExist($directory, $isCreate = false)
    {
        $isExist = true;
        if (!is_dir($directory)) $isExist = false;
        if ($isExist == false && $isCreate == true)
            $isExist = (bool) mkdir($directory, 0777, true);
        return $isExist;
    }

    public static function format($directory)
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $directory);
    }
}
