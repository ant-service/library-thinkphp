<?php

use AntService\Src\Cache;
use AntService\Src\Config;
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

if (!function_exists('useTransaction')) {
    /**
     * 使用事务
     * @param callable $callback 闭包函数
     * @param mixed ...$param 延展参数
     * @return mixed 执行结果 
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function useTransaction(callable $callback = null, ...$param)
    {
        $param = array_merge([$callback], $param);
        return DataBase::useTransaction(...$param);
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
     * @param mixed $data 传入数据,支持任意类型
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
    function errorOutput($code, string $message = '', $status = 500): void
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

if (!function_exists('syncConfig')) {
    /**
     * 配置内容同步
     * @param array $ruleConfig 依赖规则 例：['user' => 'id,nickname,age', 'user_account' => 'id,uid,username,password']
     * @return boolean
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function syncConfig($ruleConfig): void
    {
        Config::sync($ruleConfig);
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

if (!function_exists('getCache')) {
    /**
     * 获取缓存
     * @param string $key 键
     * @param mixed $defaultResult 当获取不到时，默认结果
     * @return mixed 结果
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function getCache($key, $defaultResult = null)
    {
        return Cache::get($key, $defaultResult);
    }
}

if (!function_exists('setCache')) {
    /**
     * 删除缓存
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return bool
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function setCache($key, $value, $expire)
    {
        return Cache::set($key, $value, $expire);
    }
}

if (!function_exists('getCacheExpires')) {
    /**
     * 获取缓存过期时间
     * @param string $key 键
     * @param mixed $defaultResult 当获取不到时，默认结果
     * @return int 剩余时间
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function getCacheExpires($key, $defaultResult = 0)
    {
        return Cache::getExpireTime($key, $defaultResult);
    }
}

if (!function_exists('removeCache')) {
    /**
     * 移除缓存
     * @param string $key 键
     * @return bool 
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function removeCache($key)
    {
        return Cache::remove($key);
    }
}

if (!function_exists('readConfig')) {
    /**
     * 读取配置文件
     * @param string $configName 配置文件名称 
     * 例 think.database.mysql.type 可直接获取think配置文件中的database键下的mysql键下的tpye值
     * 如值为数组则支持多级取值,以'.'连接
     * @return void
     */
    function readConfig(string $configName): string
    {
        return Config::read($configName);
    }
}

if (!function_exists('writeConfig')) {
    /**
     * 写入配置文件
     * @param string $configName 配置文件名称 
     * 例 think.database.mysql.type 可直接修改think配置文件中的database键下的mysql键下的tpye值
     * @param mixed $content
     * @return void
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function writeConfig(string $configName, $content)
    {
        return Config::write($configName, $content);
    }
}

if (!function_exists('readEnv')) {
    /**
     * 读取环境变量
     * @param string $configName 配置文件名称 
     * @return string 值
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function readEnv(string $configName)
    {
        return Config::readEnv($configName);
    }
}

if (!function_exists('getUUID')) {
    /**
     * 获取UUID
     * @return string 值
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    function getUUID()
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str, 0, 8) . '-';
        $uuid .= substr($str, 8, 4) . '-';
        $uuid .= substr($str, 12, 4) . '-';
        $uuid .= substr($str, 16, 4) . '-';
        $uuid .= substr($str, 20, 12);
        return strtoupper($uuid);
    }
}
