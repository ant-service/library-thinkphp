<?php

use AntService\Src\Config;
use AntService\Src\FileOperation;

/**
 * 下载模块
 * @author mahaibo <mahaibo@hongbang.js.cn>
 * @param string $moduleName 下载模块名称
 * @param string $moduleFile 模块存储位置
 * @return void
 */
function download($moduleName, $moduleFile)
{
    $remoteFile = Config::readEnv('STORAGE_URL') . DIRECTORY_SEPARATOR .  $moduleName;
    $localDir = str_replace($moduleName, '', $moduleFile);
    FileOperation::isExistDirectory($localDir, true);
    return copy($remoteFile, $moduleFile);
}
