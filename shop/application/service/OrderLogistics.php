<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27
 * Time: 11:22
 */

namespace app\service;


use app\admin\controller\System;
use think\Db;

class OrderLogistics
{
    /**
     * @return 配送中的物流信息
     */
    public static function GetLogisticsList($params = []){
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'add_time desc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 20;
        $data = Db::name('order_logistics')->where($where)->field($field)->order($order_by)->limit($m, $n)->select();
        if(!empty($data))
        {
            //处理数据
            foreach ($data as $k=>$v){
                /*$data[$k]['title'] = Db::table('cms_goods')
                    ->alias('goods')
                    ->join('cms_order order','goods.id=order.goods_id')
                    ->where('order.id',$data[$k]['order_id'])
                    ->value('title');*/
                /*$data[$k]['goods_url'] = Db::table('cms_goods')
                    ->alias('goods')
                    ->join('cms_order order','goods.id=order.goods_id')
                    ->where('order.id',$data[$k]['order_id'])
                    ->value('title');*/
                /*$data[$k]['images'] = Db::table('cms_goods')
                    ->alias('goods')
                    ->join('cms_order order','goods.id=order.goods_id')
                    ->where('order.id',$data[$k]['order_id'])
                    ->value('images');*/
                $data[$k]['express_name'] = Db::name('express')->where('id',$v['express_id'])->value('name');
                $data[$k]['order_num'] = Db::name('order')->where('id',$v['order_id'])->value('order_no');
                $data[$k]['start_province'] = Area::GetAreaName($v['start_province']);
                $data[$k]['start_city'] = Area::GetAreaName($v['start_city']);
                $data[$k]['start_district'] = Area::GetAreaName($v['start_district']);
                $data[$k]['end_province'] = Area::GetAreaName($v['end_province']);
                $data[$k]['end_city'] = Area::GetAreaName($v['end_city']);
                $data[$k]['end_district'] = Area::GetAreaName($v['end_district']);
                $data[$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
            }
        }
        return $data;
    }

    /**
     * 获取物流列表条件
     */
    public static function LogisticsWhere($params = []){
        $where = [];
        if(!empty($params['logistics_num']))
        {
            $where[] = ['logistics_num', 'like', '%'.$params['logistics_num'].'%'];
        }
        // 时间
        if(!empty($params['time_start']))
        {
            $where[] = ['add_time', '>', strtotime($params['time_start'])];
        }
        if(!empty($params['time_end']))
        {
            $where[] = ['add_time', '<', strtotime($params['time_end'])];
        }
        return $where;
    }

    /**
     * 获取物流列表分页
     */
    public static function LogisticsTotal($where)
    {
        return (int) Db::name('OrderLogistics')->where($where)->count();
    }

    /**
     * 删除物流列表
     */
    public static function DelLogistics($params=[]){
        // 参数是否有误
        if(empty($params['id']))
        {
            return DataReturn('商品id有误', -1);
        }
        $data = Db::table('cms_order_logistics')->where('id',$params['id'])->where('status','>',0)->delete();
        if($data == 0){
            return DataReturn('不能删除配送中的订单信息', 500);
        }
        $logs = [
            'admin_id'=>$params['admin']['id'],
            'title'=>'删除',
            'detail'=>$params['admin']['username'].'删除了物流订单: '.$params['id'],
            'add_time'=>time()
        ];
        $log = System::AdminLogSave($logs);
        return DataReturn('删除成功', 0);
    }
}