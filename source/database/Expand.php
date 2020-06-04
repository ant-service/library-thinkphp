<?php

namespace AntService\Src\DataBase;

use AntService\Src\Config;

trait Expand
{
    private static $thinkFacadeDB;

    /**
     * 执行查询
     * @param mixed $sql sql指令
     * @param array $bind 参数绑定
     * @return array 返回数据集
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function query($sql, array $bind = []): array
    {
        return self::name('')->query($sql, $bind = []);
    }

    /**
     * 执行原生SQL
     * @param string $sql sql指令
     * @param array $bind 参数绑定
     * @param bool $origin 是否原生查询
     * @return int 返回受影响行数
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function execute(string $sql, array $bind = [], bool $origin = false): int
    {
        return self::name('')->execute($sql, $bind, $origin);
    }

}
