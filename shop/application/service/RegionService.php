<?php

namespace app\service;

use app\admin\controller\System;
use think\Db;

/**
 * 地区服务层
 */
class RegionService
{
    /**
     * 获取地区名称
     * @desc    description
     * @param   [int]          $region_id [地区id]
     */
    public static function RegionName($region_id = 0)
    {
        //return empty($region_id) ? null : Db::name('area')->where(['area_id'=>intval($region_id)])->value('area_name');
        return empty($region_id) ? null : Db::name('china')->where(['id'=>intval($region_id)])->value('name');
    }

    /**
     * 获取国家名称
     */
    public static function countryName($country_id = 0)
    {
        return empty($country_id) ? null : Db::name("country")->where("id",$country_id)->value("country_name");
    }

    /**
     * 获取地区idx下列表
     * @param    [array]                    $param [输入参数]
     */
    public static function RegionItems($param = [])
    {
        $pid = isset($param['pid']) ? intval($param['pid']) : 0;
        return Db::name('Area')->where(['area_parent_id'=>$pid])->select();
    }

    /**
     * 获取地区节点数据
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function RegionNode($params = [])
    {
        $field = empty($params['field']) ? 'area_id,area_name,area_sort,area_region' : $params['field'];
        $where = empty($params['where']) ? [] : $params['where'];
        return Db::name('Area')->where($where)->field($field)->order('area_id asc')->select();
    }

    /**
     * 获取地区节点数据
     * @param    [array]          $params [输入参数]
     */
    public static function RegionNodeSon($params = [])
    {
        // id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        $field = 'area_id,area_parent_id,area_name,area_sort';
        $data = Db::name('Area')->field($field)->where(['pid'=>$id])->order('area_sort asc')->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   (Db::name('Area')->where(['area_parent_id'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['ajax_url']          =   MyUrl('admin/region/getnodeson', array('id'=>$v['id']));
                $v['delete_url']        =   MyUrl('admin/region/delete');
                $v['json']              =   json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }

    /**
     * 地区保存
     * @param    [array]          $params [输入参数]
     */
    public static function RegionSave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,16',
                'error_msg'         => '名称格式 2~16 个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'area_name'                  => $params['name'],
            'area_parent_id'       => isset($params['pid']) ? intval($params['pid']) : 0,
            'area_sort'                  => isset($params['sort']) ? intval($params['sort']) : 0
        ];

        // 添加
        if(empty($params['id']))
        {
            if(Db::name('Area')->insertGetId($data) > 0)
            {
                return DataReturn('添加成功', 0);
            }
            return DataReturn('添加失败', -100);
        } else {
            if(Db::name('Area')->where(['area_id'=>intval($params['id'])])->update($data))
            {
                return DataReturn('编辑成功', 0);
            }
            return DataReturn('编辑失败', -100);
        }
    }

    /**
     * 地区删除
     * @param    [array]          $params [输入参数]
     */
    public static function RegionDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '删除数据id有误',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'admin',
                'error_msg'         => '用户信息有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 是否还有子数据
        $temp_count = Db::name('Area')->where(['pid'=>$params['id']])->count();
        if($temp_count > 0)
        {
            return DataReturn('请先删除子数据', -10);
        }

        $params['name'] = Db::name('Area')->where(['area_id'=>$params['id']])->value('area_name');
        // 开始删除
        if(Db::name('Area')->where(['area_id'=>$params['id']])->delete())
        {
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$params['admin']['username'].'删除了地区：'.$params['name'],
                'add_time'=>time()
            ];
            $log = System::AdminLogSave($logs);
            return DataReturn('删除成功', 0);
        }
        return DataReturn('删除失败', -100);
    }
}
?>