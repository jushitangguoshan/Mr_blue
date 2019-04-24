<?php

namespace app\service;

use app\admin\controller\System;
use PhpMyAdmin\SysInfo;
use think\Db;
use think\facade\Hook;
use app\service\RegionService;

/**
 * 财务管理
 */

class FinanceService
{

    /**
     * 收款列表管理
     */
    public static function GatheringList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'id desc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        //获取收款数据
        $field = 'o.*,u.username,u.mobile,pm.name as pm_name,ep.name as ep_name';

        $data = Db::name('Order')->alias('o')
            ->join('user u', 'u.id=o.user_id')
            ->join('payment pm', 'o.payment_id=pm.id')
            ->join('express ep', 'o.express_id=ep.id')
            ->where('pay_status',1)->where($where)->field($field)->order($order_by)->limit($m, $n)->select();
        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 收款列表条件
     * @param    [array]          $params [输入参数]
     */
    public static function GatheringListWhere($params = [])
    {
        $where = [];
        if(!empty($params['keywords']))
        {
            $where[] =['order_no','=', $params['keywords']];//
        }

        // 是否更多条件
        if(isset($params['is_more']) && $params['is_more'] == 1)
        {
            // 性别
            if(isset($params['gender']) && $params['gender'] > -1)
            {
                $where[] = ['gender', '=', intval($params['gender'])];
            }

            // 时间
            if(!empty($params['time_start']))
            {
                $where[] = ['pay_time', '>', strtotime($params['time_start'])];
            }
            if(!empty($params['time_end']))
            {
                $where[] = ['pay_time', '<', strtotime($params['time_end'])];
            }
        }
        return $where;
    }

    /**
     * 收款总数
     * @param    [array]          $where [条件]
     */
    public static function GatheringTotal($where)
    {
        return (int) Db::name('Order')->where('pay_status',1)->where($where)->count();
    }



    /**
     * 付款列表管理
     */
    public static function PaymentList($where)
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'id desc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        //DB操作
        //$data = Db::name('Order')->alias('o')->join('user u', 'u.id=o.user_id')
        //        ->join('payment pm', 'o.payment_id=pm.id')->where('pay_status',1)->where($where)->field($field)->select();

        $data = Db::name('Order')->alias('o')->join('user u', 'u.id=o.user_id')
            ->join('payment pm', 'o.payment_id=pm.id')->where('pay_status',1)->where($where)->field($field)->select();

        return DataReturn('处理成功', 0, $data);
    }

    /**
     * 付款列表条件
     * @param    [array]          $params [输入参数]
     */
    public static function PaymentListWhere($params = [])
    {
        $where = [];
        if(!empty($params['keywords']))
        {
            $where[] =['order_no','=', intval($params['keywords'])];//
        }

        // 是否更多条件
        if(isset($params['is_more']) && $params['is_more'] == 1)
        {
            // 性别
            if(isset($params['gender']) && $params['gender'] > -1)
            {
                $where[] = ['gender', '=', intval($params['gender'])];
            }

            // 时间
            if(!empty($params['time_start']))
            {
                $where[] = ['pay_time', '>', strtotime($params['time_start'])];
            }
            if(!empty($params['time_end']))
            {
                $where[] = ['pay_time', '<', strtotime($params['time_end'])];
            }
        }
        return $where;
    }


    /**
     * 付款总数
     * @param    [array]          $where [条件]
     */
    public static function PaymentTotal($where)
    {
        return (int) Db::name('Order')->where('pay_status',1)->where($where)->count();
    }

    /**
     * 获取收入信息
     */
    public static function GetIncome(){
        $field = 'pay_price,preferential_price,total_price';
        $nowTime = time();
        $dayTime = $nowTime - 1*24*60*60; //24小时以前
        $weekTime = $nowTime - 7*24*60*60; //一周以前
        $monthTime = $nowTime - 30*24*60*60; //一月以前
        $yearTime = $nowTime - 365*24*60*60; //一年以前

        return 11;
    }

    /**
     * 获取详细信息条件
     */
    public static function OrderDetailWhere($params = []){
        // 条件初始化
        $where = [
            ['pay_status', '>', 0],
        ];
        if(!empty($params['pay_time']))
        {
            $where[] = ['pay_time', '>', $params['pay_time']];
        }

        if(!empty($params['keywords']))
        {
            $where[] = ['order_no|username', 'like', '%'.$params['keywords'] . '%'];
        }

        //支付方式
        if(isset($params['payment_id']) && $params['payment_id'] > -1)
        {
            $where[] = ['payment_id', '=', intval($params['payment_id'])];
        }
        // 时间
        if(!empty($params['time_start']))
        {
            $where[] = ['pay_time', '>', strtotime($params['time_start'])];
        }
        if(!empty($params['time_end']))
        {
            $where[] = ['pay_time', '<', strtotime($params['time_end'])];
        }

        return $where;
    }

    /**
     * 获取总数
     */
    public static function OrderDetailTotal($where=[]){
        $field = 'o.id,o.user_id,o.order_no,o.pay_number,o.pay_user_number,o.payment_id,o.preferential_price,o.price,o.total_price,o.pay_price,o.pay_time,u.username,u.grade,g.title,g.images,g.inventory_unit,p.name';

        return (int) $data = Db::name('Order')->field($field)
            ->alias('o')
            ->join('User u','o.user_id = u.id')
            ->join('Payment p','o.payment_id = p.id')
            ->where($where)
            ->count();
    }

    /**
     * 根据时间获取某个时间段数据
     */
    public static function GetTimeFinance($time){
        $field = 'pay_price,preferential_price,total_price';
        $data = Db::name('Order')->field($field)->where('pay_time','>',$time)->select();
        $price = [
            'total_price'=>0.00,
            'actual_price'=>0.00,
            'favorable_price'=>0.00
        ];
        if(!empty($data)){
            foreach ($data as $v){
                $price['total_price'] += $v['total_price']; //收入总价
                $price['actual_price'] += $v['pay_price'];  //实际金额
                $price['favorable_price'] += $v['preferential_price'];  //优惠金额
            }
        }
        //保留小数点2位
        $price = [
            'total_price'=>PriceNumberFormat($price['total_price']),
            'actual_price'=>PriceNumberFormat($price['actual_price']),
            'favorable_price'=>PriceNumberFormat($price['favorable_price'])
        ];
        return $price;
    }

    /**
     * 获取日收入报表详情
     */
    public static function GetOrderDetail($params = []){
        $where = empty($params['where']) ? [] : $params['where'];
        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;
        $order_by = empty($params['order_by']) ? 'id desc' : $params['order_by'];

        $field = 'o.id,o.user_id,o.order_no,o.pay_number,o.pay_user_number,o.payment_id,o.preferential_price,o.price,o.total_price,o.pay_price,o.pay_time,u.username,u.grade,p.name';
        $data = Db::name('Order')->field($field)
            ->alias('o')
            ->join('User u','o.user_id = u.id')
            ->join('Payment p','o.payment_id = p.id')
            ->where($where)->limit($m, $n)->order($order_by)->select();
        return $data;
    }
}





