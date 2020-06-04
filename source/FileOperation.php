<?php

namespace AntService\Src;

use AntService\Src\File\Directory;

class FileOperation
{
    use Directory {
        Directory::isExist as isExistDirectory;
        Directory::format as formatDirectory;
    }
}
