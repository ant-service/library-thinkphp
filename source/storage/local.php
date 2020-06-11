<?php

use AntService\Src\Output;
use AntService\Src\Request;

/**
 * 下载模块
 * @author mahaibo <mahaibo@hongbang.js.cn>
 * @param string $moduleName 下载模块名称
 * @param string $moduleFile 模块存储位置
 * @return void
 */
function download($moduleName, $moduleFile)
{
    $storagePath = Request::rootDirectory() . 'storage' . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $moduleName;
    if (!copy($storagePath, $moduleFile)) Output::error('WRITE_PERMISSION_DENIED', '模块写入权限不足', 500);
}
