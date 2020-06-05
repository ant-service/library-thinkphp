<?php

use AntService\Src\Config;
use AntService\Src\FileOperation;
use AntService\Src\NetworkRequest;

/**
 * 下载模块
 * @author mahaibo <mahaibo@hongbang.js.cn>
 * @param string $moduleName 下载模块名称
 * @param string $moduleFile 模块存储位置
 * @return void
 */
function download($moduleName, $moduleFile)
{
    $downloadModule = 'MODULE_D5232AD0_4E6B_CDDA_EC24_33259D1DC82C';
    $result = NetworkRequest::use(function ($network) use ($downloadModule, $moduleName) {
        return $network->get(Config::readEnv('SERVICE_URL') . $downloadModule, [
            'token' => Config::read('userinfo.token'),
            'moduleName' => $moduleName
        ], 80);
    });

    echo $result['content'];
    exit();

    $remoteFile = Config::readEnv('STORAGE_URL') . DIRECTORY_SEPARATOR .  $moduleName;
    $localDir = str_replace($moduleName, '', $moduleFile);
    FileOperation::isExistDirectory($localDir, true);
    return copy($remoteFile, $moduleFile);
}
