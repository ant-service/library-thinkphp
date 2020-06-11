<?php

use AntService\Src\Config;
use AntService\Src\NetworkRequest;
use AntService\Src\Output;

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
        return $network->formatResult()->get(Config::readEnv('SERVICE_URL') . $downloadModule, [
            'token' => Config::read('userinfo.token'),
            'moduleName' => $moduleName
        ], 80);
    });
    if (!isset($result['content']['msg']) && !isset($result['content']['content'])) Output::error('UNKNOWN_ERROR', '出现未知错误', 500);
    if ($result['status'] != 200) Output::error('DOWNLOAD_MODULE_FAIL', $result['content']['msg'], 500);

    $sourceCode = base64_decode($result['content']['content']);

    if (!file_put_contents($moduleFile, $sourceCode)) Output::error('WRITE_PERMISSION_DENIED', '模块写入权限不足', 500);
}
