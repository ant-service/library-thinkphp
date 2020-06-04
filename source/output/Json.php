<?php

namespace AntService\Src\Output;

use AntService\Src\DataType;

/**
 * 数据输出基本接口
 * @author mahaibo <mahaibo@hongbang.js.cn>
 */
class Json implements BaseInterface
{
    public static function success($data)
    {
        return DataType::convertJson($data, true);
    }

    public static function error($code, string $message = '')
    {
        return DataType::convertJson([
            'code' => $code,
            'msg' => $message,
        ]);
    }

    public static function initResponse()
    {
        header("Content-type: application/json; charset=utf-8");
    }
}
