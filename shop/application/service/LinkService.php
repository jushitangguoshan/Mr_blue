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

/**
 * 友情链接服务层
 */
class LinkService
{
    /**
     * 列表
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function LinkList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $data = Db::name('Link')->where($where)->order('sort asc')->select();
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 保存
     * @desc    description
     * @param   [array]          $params [输入参数]
     */
    public static function LinkSave($params = [])
    {
        // 请求类型
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'name',
                'checked_data'      => '2,16',
                'error_msg'         => '名称格式 2~16 个字符',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'url',
                'checked_data'      => 'CheckUrl',
                'error_msg'         => '链接地址格式有误',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'sort',
                'checked_data'      => '3',
                'error_msg'         => '顺序 0~255 之间的数值',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'is_new_window_open',
                'checked_data'      => [0,1],
                'error_msg'         => '是否新窗口打开范围值有误',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'is_enable',
                'checked_data'      => [0,1],
                'error_msg'         => '是否显示范围值有误',
            ],
            [
                'checked_type'      => 'length',
                'key_name'          => 'describe',
                'checked_data'      => '60',
                'error_msg'         => '描述不能大于60个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'name'                  => $params['name'],
            'describe'              => $params['describe'],
            'url'                   => $params['url'],
            'sort'                  => intval($params['sort']),
            'is_enable'             => intval($params['is_enable']),
            'is_new_window_open'    => intval($params['is_new_window_open']),
        ];

        if(empty($params['id']))
        {
            $data['add_time'] = time();
            if(Db::name('Link')->insertGetId($data) > 0)
            {
                return DataReturn('添加成功', 0);
            }
            return DataReturn('添加失败', -100);
        } else {
            $data['upd_time'] = time();
            if(Db::name('Link')->where(['id'=>intval($params['id'])])->update($data))
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
    public static function LinkDelete($params = [])
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
        $params['name'] = Db::name('Link')->where(['id'=>$params['id']])->value('name');
        // 删除操作
        if(Db::name('Link')->where(['id'=>$params['id']])->delete())
        {
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$params['admin']['username'].'删除了: '.$params['name'],
                'add_time'=>time()
            ];
            $log = System::AdminLogSave($logs);
            return DataReturn('删除成功');
        }

        return DataReturn('删除失败或资源不存在', -100);
    }

    /**
     * 状态更新
     * @param    [array]          $params [输入参数]
     */
    public static function LinkStatusUpdate($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '操作id有误',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'state',
                'checked_data'      => [0,1],
                'error_msg'         => '状态有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据更新
        if(Db::name('Link')->where(['id'=>intval($params['id'])])->update(['is_enable'=>intval($params['state'])]))
        {
            return DataReturn('编辑成功');
        }
        return DataReturn('编辑失败或数据未改变', -100);
    }
}
?>