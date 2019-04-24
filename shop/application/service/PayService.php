<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/29
 * Time: 17:36
 */

namespace app\service;

use app\admin\controller\System;
use think\Db;

class PayService
{
    /**
     * 获取支付节点数据
     * @param    [array]          $params [输入参数]
     */
    public static function PayNodeSon($params = [])
    {
        // id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        $field = 'id,name,icon,sort,is_enable';
        $data = Db::name('Payment')->field($field)->order('sort asc')->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   'no';
                $v['delete_url']        =   MyUrl('admin/zoology/delete');
                $v['icon_url']          =   ResourcesService::AttachmentPathViewHandle($v['icon']);
                $v['json']              =   json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }

    /**
     * 删除支付方式
     */
    public static function PayDelete($params=[]){
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

        // 开始删除
        $payType = Db::name('Payment')->where(['id'=>intval($params['id'])])->value('name');
        if(Db::name('Payment')->where(['id'=>intval($params['id'])])->delete())
        {
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$params['admin']['username'].'删除了：（'.$payType.' ）支付方式',
                'add_time'=>time()
            ];
            $log = System::AdminLogSave($logs);
            return DataReturn('删除成功', 0);
        }
        return DataReturn('删除失败', -100);
    }


}