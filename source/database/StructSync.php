<?php

namespace AntService\Src\DataBase;

use AntService\Src\Config;
use AntService\Src\DataType;
use AntService\Src\Output;
use Exception;

trait StructSync
{

    use Expand;

    private static $tableData;

    /**
     * 数据库结构同步
     * @param array $ruleConfig 依赖规则 例：['user' => 'id,nickname,age', 'user_account' => 'id,uid,username,password']
     * @return boolean
     * @author mahaibo <mahaibo@hongbang.js.cn>
     */
    public static function dbDepend($ruleConfig)
    {
        foreach ($ruleConfig as $tableName => $fieldStr) {
            self::setTableName($tableName);
            $fieldArr = DataType::convertArray($fieldStr);
            $tableStruct = self::getTableStruct($tableName);
            if (!$tableStruct) Output::error('GET_TABLE_FAIL', '获取表结构失败', 500);
            try {
                $tableFields = self::getTableFields($tableName);
            } catch (Exception $e) {
                $databaseName = Config::read('think.database.mysql.database');
                $errorContent = "SQLSTATE[HY000] [1049] Unknown database '" . $databaseName . "'";
                if ($e->getMessage() == $errorContent) {
                    self::createDatabase($databaseName);
                }
                $tableFields = array();
                self::getThinkDB();
            }
            if (count($tableFields)) {
                $fieldArr = array_diff($fieldArr, $tableFields);
                foreach ($fieldArr as $field) {
                    self::addColumn(
                        strval($field),
                        strval($tableStruct[$field]['type']),
                        intval($tableStruct[$field]['length']),
                        strval($tableStruct[$field]['default']),
                        strval($tableStruct[$field]['comment']),
                        boolval($tableStruct[$field]['is_pk'])
                    );
                }
                if (count($fieldArr)) self::updateTable();
            } else {
                foreach ($fieldArr as $field) {
                    self::addColumn(
                        strval($field),
                        strval($tableStruct[$field]['type']),
                        intval($tableStruct[$field]['length']),
                        strval($tableStruct[$field]['default']),
                        strval($tableStruct[$field]['comment']),
                        boolval($tableStruct[$field]['is_pk'])
                    );
                }
                if (count($fieldArr)) self::createTable();
            }
        }
        $_SERVER['is_init_module'] = true;
    }

    public static function setTableName(string $tableName, string $tableAlias = '')
    {
        list(self::$tableData['tableName'], self::$tableData['tableAlias']) = [$tableName, $tableAlias];
        return new self;
    }

    public static function addColumn(string $name, string $type, int $length, $default, string $comment, bool $isPk = false)
    {
        $columnStr = '`' . $name . '` ' . $type;

        if ($type == 'json') $columnStr .= ' ';
        else $columnStr .= '(' . $length . ') ';

        if ($isPk) $columnStr .= 'primary key ';

        if ($type == 'json') $columnStr .= '';
        elseif ($type == 'varchar' || $type == 'char') $columnStr .= 'default ' . '\'' . strval($default) . '\'';
        elseif ($type == 'int' || $type == 'tinyint') $columnStr .= 'default ' . intval($default);
        elseif (is_null($default)) $columnStr .= 'null';

        $columnStr .= ' COMMENT ' . '\'' . $comment . '\'';
        self::$tableData['columnStr'][] =  $columnStr;
        return new self;
    }

    public static function createTable()
    {
        if (!isset(self::$tableData['tableName']) || !is_string(self::$tableData['tableName']) || self::$tableData['tableName'] == '') Output::error('GET_TABLENAME_FAILE', '表名未设置');
        if (!isset(self::$tableData['columnStr']) || !is_array(self::$tableData['columnStr']) || count(self::$tableData['columnStr']) == 0) Output::error('GET_COLUMN_FAILE', '数据表列名未设置');
        $sql = 'CREATE TABLE ' . '`' . self::$tableData['tableName'] . '`(' . implode(',', self::$tableData['columnStr']) . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=' . '\'' . self::$tableData['tableAlias'] . '\'';
        self::$tableData = array();

        $randNum = time() . rand(1000, 9999);
        $thinkDataBase = self::getThinkApp(true)->make('think\facade\Db', [], true);
        $databaseInfo = Config::read('think.database');
        $newDatabaseInfo = [
            'mysql_' . $randNum => $databaseInfo['mysql']
        ];
        $thinkDataBase::setConfig([
            'default' => Config::read('think.default.database') . '_' . $randNum,
            'connections' => $newDatabaseInfo
        ]);
        return (bool) $thinkDataBase::name('')->execute($sql);
    }

    public static function updateTable()
    {
        if (!isset(self::$tableData['tableName']) || !is_string(self::$tableData['tableName']) || self::$tableData['tableName'] == '') Output::error('GET_TABLENAME_FAILE', '表名未设置');
        if (!isset(self::$tableData['columnStr']) || !is_array(self::$tableData['columnStr']) || count(self::$tableData['columnStr']) == 0) Output::error('GET_COLUMN_FAILE', '数据表列名未设置');
        foreach (self::$tableData['columnStr'] as $key => $value) {
            self::$tableData['columnStr'][$key] = 'ADD ' . $value;
        }
        $sql = 'ALTER TABLE ' . '`' . self::$tableData['tableName'] . '` ' . implode(',', self::$tableData['columnStr']);
        self::$tableData = array();
        return (bool) self::execute($sql);
    }

    public static function getTableStruct($tableName)
    {
        $serviceUrl = Config::readEnv('SERVICE_URL');
        if ($serviceUrl) {
            $path = str_replace('/index.php', '', $serviceUrl) . 'storage/dbstruct' . '/' . strtolower($tableName) . '.json';
            $result = file_get_contents($path);
            if ($result === false) return array();
            return DataType::convertArray($result);
        }
        return array();
    }

    public static function createDatabase($databaseName)
    {
        $randNum = time() . rand(1000, 9999);
        $thinkDataBase = self::getThinkApp(true)->make('think\facade\Db', [], true);
        $databaseInfo = Config::read('think.database');
        $databaseInfo['mysql']['database'] = null;
        $newDatabaseInfo = [
            'mysql_' . $randNum => $databaseInfo['mysql']
        ];
        $thinkDataBase::setConfig([
            'default' => Config::read('think.default.database') . '_' . $randNum,
            'connections' => $newDatabaseInfo
        ]);
        $sql = 'CREATE DATABASE IF NOT EXISTS ' . $databaseName . ' DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_general_ci';
        return (bool) $thinkDataBase::name('')->execute($sql);
    }
}
