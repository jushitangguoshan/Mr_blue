<?php

namespace app\service;

use think\Db;

/**
 * SQL控制台服务层
 */
class SqlconsoleService
{
    /**
     * SQL执行
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function Implement($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'sql',
                'error_msg'         => '执行SQL不能为空',
            ]
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 转为数组
        $sql_all = preg_split("/;[\r\n]+/", $params['sql']);

        $success = 0;
        $failure = 0;
        foreach($sql_all as $v)
        {
            if (!empty($v))
            {
                if(Db::execute($v) !== false)
                {
                    $success++;
                } else {
                    $failure++;
                }               
            }
        }

        if($failure > 0)
        {
            return DataReturn('sql运行失败['.$failure.']条', -1);
        }

        return DataReturn('sql运行成功', 0, 'sql运行成功[success: '.$success.', failure: '.$failure.']');
    }
}
?>