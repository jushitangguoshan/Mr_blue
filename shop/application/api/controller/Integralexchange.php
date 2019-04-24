<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/23 0023
 * Time: 14:00
 */

namespace app\api\controller;


use think\Db;

class Integralexchange extends Common
{
    /**
     * [__construct 构造方法]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-03T12:39:08+0800
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 是否登录
        $this->Is_Login();
    }

    /**
     * 兑换商品列表
     */
    public function exchangeShopList()
    {
        $params = input();
        $number = empty($params['number']) ? 10 : $params['number'];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        $where = ["is_shelves"=>1,'is_exchange'=>1];
        $total = Db::name("goods")->where($where)->count();
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);

        $files = "title,images,price,exchange_stime,exchange_etime";
        $data = Db::name("goods")->field($files)->where($where)->limit($start,$number)->order("id desc")->select();
        $money = Db::name("exchange_proportion")->where(["type"=>"goods","is_enable"=>1])->find();
        foreach($data as &$val){
            $val['exchange'] = $val['price']*($money['exchange']/$money['contrast_exchange']);
        }

        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data,
        ];
        return DataReturn("success",200,$result);
    }


    /**
     * 兑换商品
     */
    /*public function exchangeShop()
    {
        $params = input();
        $params['user'] = $this->user;
        $user_integral = $params['user']['integral'];
        $data = Db::name("goods")->where("id",$params["id"])->find();
        $money = Db::name("exchange_proportion")->where(["type"=>"goods","is_enable"=>1])->find();
        $shop_integral = $data['price']*($money['exchange']/$money['contrast_exchange']);
        if($user_integral < $shop_integral){
            return DataReturn("积分余额不足");
        }
        Db::name("")

    }*/

    /**
     * 兑换优惠卷
     */
    public function exchangeCoupon()
    {
        echo 1;
        $params = input();
        $number = empty($params['number']) ? 10 : $params['number'];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        $where = ["is_shelves"=>1,'is_exchange'=>1];
        $total = Db::name("goods")->where($where)->count();
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);

        $files = "title,images,price,exchange_stime,exchange_etime";
        $data = Db::name("goods")->field($files)->where($where)->limit($start,$number)->order("id desc")->select();
        $money = Db::name("exchange_proportion")->where(["type"=>"coupon","is_enable"=>1])->find();
        foreach($data as &$val){
            $val['exchange'] = $val['price']*($money['exchange']/$money['contrast_exchange']);
        }

        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data,
        ];
        return DataReturn("success",200,$result);
    }
}