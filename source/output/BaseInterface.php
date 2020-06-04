<?php

namespace AntService\Src\Output;
/**
 * 数据输出基本接口
 * @author mahaibo <mahaibo@hongbang.js.cn>
 */
interface BaseInterface
{
    /**
     * 成功返回
     * @param any $data 待返回内容
     * @return void
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function success($data);

    /**
     * 失败返回
     * @param string|int $code 错误码
     * @param string $message 提示内容
     * @return void
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function error($code, string $message = '');

    /**
     * 初始化响应
     * @return void
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function initResponse();
}
