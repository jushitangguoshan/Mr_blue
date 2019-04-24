<?php

namespace app\service;

use think\Db;
use app\service\ResourcesService;

/**
 * 应用服务层
 */
class PluginsService
{
    /**
     * 根据应用标记获取数据
     * @desc    description
     * @param   [string]          $plugins      [应用标记]
     * @param   [array]           $images_field [图片字段]
     */
    public static function PluginsData($plugins, $images_field = [])
    {
        // 获取数据
        $data = Db::name('Plugins')->where(['plugins'=>$plugins])->value('data');
        if(!empty($data))
        {
            $data = json_decode($data, true);

            // 是否有图片需要处理
            if(!empty($images_field) && is_array($images_field))
            {
                foreach($images_field as $field)
                {
                    if(isset($data[$field]))
                    {
                        $data[$field.'_old'] = $data[$field];
                        $data[$field] = ResourcesService::AttachmentPathViewHandle($data[$field]);
                    }
                }
            }
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 应用数据保存
     * @desc    description
     * @param   [string]          $plugins [应用标记]
     */
    public static function PluginsDataSave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'plugins',
                'error_msg'         => '应用标记不能为空',
            ],
            [
                'checked_type'      => 'isset',
                'key_name'          => 'data',
                'error_msg'         => '数据参数不能为空',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据更新
        if(Db::name('Plugins')->where(['plugins'=>$params['plugins']])->update(['data'=>json_encode($params['data']), 'upd_time'=>time()]))
        {
            return DataReturn('操作成功');
        }
        return DataReturn('操作失败', -100);
    }
}
?>