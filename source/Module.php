<?php


namespace AntService\Src;

class Module
{
    private static $arguments = array();

    public static function use(string $moduleName, array $arguments = array())
    {
        $userDir = Request::rootDirectory();

        $storageMode = Config::readEnv('MODULE_STORAGE');
        $loadFilePath = __DIR__ . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . strtolower($storageMode) . '.php';
   
        if (is_file($loadFilePath)) require_once $loadFilePath;

        $moduleName = strtoupper($moduleName);
        self::setArguments($moduleName, $arguments);

        $moduleFile = $userDir . 'module/' . $moduleName;

        $isDownload = false;
        if (!is_file($moduleFile)) {
            $isDownload = true;
            download($moduleName, $moduleFile);
        }

        require_once $moduleFile;

        if (!class_exists($moduleName)) {
            Output::error('VERIFY_CLASS_FAIL', '验证模块类失败,该模块[' . $moduleName . ']未实现同名类');
        }

        $isDownload and self::firstLoad($moduleName);
        return new $moduleName();
    }

    private static function setArguments($moduleName, $arguments)
    {
        self::$arguments[$moduleName] = $arguments;
    }

    public static function getArguments(string $key = ''): array
    {
        if ($key == '') {
            return self::$arguments;
        }
        return self::$arguments[$key] ?? array();
    }

    /**
     * 模块首次载入/下载加载模块
     * @author mahaibo <mahaibo@hongbang.js.cn>
     * @param string $moduleName 模块名称
     * @return void
     */
    private static function firstLoad(string $moduleName): void
    {
        //模块初始化操作
        is_callable([$moduleName, 'init']) and self::use($moduleName)::init();
    }
}
