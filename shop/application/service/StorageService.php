<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2019 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\service;

use think\Db;
use app\service\GoodsService;
use app\service\ResourcesService;

/**
 * 仓库服务层
 */
class StorageService
{
    /**
     * 仓库列表
     * @param    [array]          $params [输入参数]
     */
    public static function StorageList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        // $order_by = empty($params['order_by']) ? 'sort asc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        // 获取仓库列表
        // $data = Db::name('Storage')->where($where)->order($order_by)->limit($m, $n)->select();
        $data = Db::name('Storage')->where($where)->limit($m, $n)->select();
        if(!empty($data))
        {
            $common_is_enable_tips = lang('common_is_enable_tips');
            foreach($data as &$v)
            {
                //仓库所属地
                // 获取城市名称
                if(isset($v['city_id']))
                {
                    $v['city_name'] = Db::name('Area')->where(['area_id'=>$v['city_id']])->value('area_name');
                 }
                //获取县区名称
                 if(isset($v['area_id']))
                {
                    $v['area_name'] = Db::name('Area')->where(['area_id'=>$v['area_id']])->value('area_name');
                 }


                // 时间
                if(isset($v['adtime']))
                {
                    $v['add_time_time'] = date('Y-m-d H:i:s', $v['adtime']);
                }
               
            }
        }
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 仓库总数
     * @param    [array]          $where [条件]
     */
    public static function StorageTotal($where)
    {
        return (int) Db::name('Storage')->where($where)->count();
    }

    /**
     * 列表条件
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function StorageListWhere($params = [])
    {
        $where = [];

        if(!empty($params['keywords']))
        {
            $where[] = ['name', 'like', '%'.$params['keywords'].'%'];
        }

        return $where;
    }

    /**
     * 保存
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function StorageSave($params = [])
    {
        // 请求类型
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,30',
                'error_msg'         => '名称格式 2~30 个字符',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'pro',
                'error_msg'         => '请选择地区',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'city',
                'error_msg'         => '请选择地区',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'area',
                'error_msg'         => '请选择地区',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'address',
                'checked_data'      => '2,50',
                'error_msg'         => '地址格式 2~50 个字符',
            ],
           
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'name'              => $params['name'],
            'pro_id'        => intval($params['pro']),
            'city_id'        => intval($params['city']),
            'area_id'        => intval($params['area']),
            'address'       => empty($params['address']) ? '' : $params['address'],
        ];

        if(empty($params['id']))
        {
            $data['adtime'] = time();
            if(Db::name('Storage')->insertGetId($data) > 0)
            {
                return DataReturn('添加成功', 0);
            }
            return DataReturn('添加失败', -100);
        } else {
            // $data['upd_time'] = time();      //更新时间
            if(Db::name('Storage')->where(['id'=>intval($params['id'])])->update($data))
            {
                return DataReturn('编辑成功', 0);
            }
            return DataReturn('编辑失败', -100); 
        }
    }

     /**
     * 删除
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function StorageDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '操作id有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 删除操作
        if(Db::name('Storage')->where(['id'=>$params['id']])->delete())
        {
            return DataReturn('删除成功');
        }

        return DataReturn('删除失败或资源不存在', -100);
    }


}
?>