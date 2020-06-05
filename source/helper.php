<?php

use AntService\Src\Cache;
use AntService\Src\DataBase;
use AntService\Src\DataType;
use AntService\Src\Module;
use AntService\Src\OutPut;
use AntService\Src\Request;
use AntService\Src\Validate;

if (!function_exists('useModule')) {
    /**
     * 使用数据库
     * @param callable $callback 闭包函数
     * @param mixed ...$param 延展参数
     * @return mixed 执行结果 
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function useModule(string $moduleName, array $arguments = array())
    {
        return Module::use($moduleName, $arguments);
    }
}

if (!function_exists('useCache')) {
    /**
     * 使用缓存
     * @param mixed ...$param 传入参数
     * set $key,$value,$expires
     * get $key
     * @return mixed 设置结果(bool)/获取结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function useCache(...$param)
    {
        return Cache::use(...$param);
    }
}

if (!function_exists('useDataBase')) {
    /**
     * 使用数据库
     * @param callable $callback 闭包函数
     * @param mixed ...$param 延展参数
     * @return mixed 执行结果 
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function useDataBase(callable $callback = null, ...$param)
    {
        $param = array_merge([$callback], $param);
        return DataBase::use(...$param);
    }
}

if (!function_exists('useValidate')) {
    /**
     * 使用验证器
     * @param callable $callback 闭包函数
     * @return mixed 执行结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function useValidate(callable $callback = null)
    {
        $validate = new Validate();
        if (is_callable($callback)) {
            return $callback($validate);
        }
        return $validate;
    }
}

if (!function_exists('useRequest')) {

    /**
     * 使用请求
     * @param callable $callback 闭包函数
     * @return void
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function useRequest(callable $callback = null)
    {
        $request = new Request();
        if (is_callable($callback)) {
            return $callback($request);
        }
        return $request;
    }
}

if (!function_exists('convertArray')) {

    /**
     * 转换成数组
     * @param mixed $variate 带转换内容
     * @param string $delimiter 分割符号,字符串转换时需要
     * @return array 转换后结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function convertArray($variate, $delimiter = ',')
    {
        return DataType::convertArray($variate, $delimiter);
    }
}

if (!function_exists('convertObject')) {
    /**
     * 转换成对象
     * @param mixed $variate 带转换内容
     * @return object 转换后结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function convertObject($variate)
    {
        return DataType::convertObject($variate);
    }
}

if (!function_exists('convertString')) {
    /**
     * 转换成字符串
     * @param mixed $variate 带转换内容
     * @param string $delimiter 分割符号,字符串转换时需要
     * @return string 转换后结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function convertString($variate, $delimiter = ',')
    {
        return DataType::convertString($variate, $delimiter);
    }
}

if (!function_exists('convertXml')) {
    /**
     * 转换成XML
     * @param mixed $variate 带转换内容
     * @param string $rootElement XML根
     * @return string 转换后结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function convertXml($variate, $rootElement = 'xml')
    {
        return DataType::convertXml($variate, $rootElement);
    }
}

if (!function_exists('convertJson')) {
    /**
     * 转换成Json
     * @param mixed $variate 带转换内容
     * @param bool $isFormat 是否格式化
     * @return string 转换后结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function convertJson($variate, $isFormat = false)
    {
        return DataType::convertJson($variate, $isFormat);
    }
}

if (!function_exists('successOutput')) {
    /**
     * 成功返回
     * @param any $data 传入数据,支持任意类型
     * @author mahaibo <mahaibo@hongbang.js.cn>
     * @return array
     */
    function successOutput($data): void
    {
        OutPut::success($data);
    }
}

if (!function_exists('errorOutput')) {
    /**
     * 失败返回
     * @param int|string $code 错误码
     * @param string $message 错误内容
     * @param integer $status http状态码
     * @author mahaibo <mahaibo@hongbang.js.cn>
     * @return array
     */
    function error($code, string $message = '', $status = 500): void
    {
        OutPut::error($code, $message, $status);
    }
}

if (!function_exists('syncDataBase')) {
    /**
     * 数据库结构同步
     * @param array $ruleConfig 依赖规则 例：['user' => 'id,nickname,age', 'user_account' => 'id,uid,username,password']
     * @return boolean
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function syncDataBase($ruleConfig): void
    {
        DataBase::dbDepend($ruleConfig);
    }
}

if (!function_exists('getRequestParam')) {

    /**
     * 获取模块请求参数
     * @param string $moduleName 模块名称
     * @return array 参数内容
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function getRequestParam($moduleName): array
    {
        return Module::getArguments($moduleName);
    }
}
