<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16 0016
 * Time: 15:16
 */

namespace app\api\controller;


use app\service\GoodsService;
use think\Db;

class Usergoodsorder extends Common
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
     * 订单列表
     */
    public function stayPaymentList()
    {
        $params = input();
        $params["user"] = $this->user;
        //$this->user['id'] = "90";
        $where = ['user_id' => $params["user"]['id'],"status"=>$params['goods_id']];
        $data = $this->commend($where);
        if(!$data){
            return DataReturn("没有待收货的订单");
        }
        return DataReturn("success",200,$data);
    }


    /**
     * 待支付订单列表
     */
    public function stayPayment()
    {
        $params = input();
        $params["user"] = $this->user;
        //$this->user['id'] = "77";
        $where = ['user_id' => $params["user"]['id'],"status"=>$params['goods_id']];
        $data = $this->commend($where);
        if(!$data){
            return DataReturn("没有未支付的订单");
        }
        return DataReturn("success",200,$data);
    }

    /**
     * 待收货订单列表
     */
    public function stayDeliverGoods()
    {
        $params = input();
        $params["user"] = $this->user;
        //$this->user['id'] = "90";
        $where = ['user_id' => $params["user"]['id'],"status"=>$params['goods_id']];
        $data = $this->commend($where);
        if(!$data){
            return DataReturn("没有待收货的订单");
        }
        return DataReturn("success",200,$data);
    }

    /**
     * 待评论订单列表
     */
    public function stayEvaluate()
    {
        $params = input();
        $params["user"] = $this->user;
        //$this->user['id'] = "90";
        $where = ['user_id' => $params["user"]['id'],"status"=>$params['goods_id']];
        $data = $this->commend($where);
        if(!$data){
            return DataReturn("没有订单待评论");
        }
        return DataReturn("success",200,$data);
    }

    /**
     * 公共订单方法
     */
    public function commend($where)
    {
        return Db::name("order")->alias("o")->join("goods g","o.goods_id=g.id","left")->where($where)->select();
    }

    /**
     * 取消订单
     */
    public function delPayment()
    {
        $params = input();
        $params['user'] = $this->user;
       /* $params['id'] = "1";
        $params['user']['id'] = "90";*/
        $where = ["user_id"=>$params['user']['id'],"goods_id"=>$params['id']];
        $data = Db::name("order")->where($where)->delete();
        if(!$data){
            return DataReturn("取消订单失败");
        }
        return DataReturn("取消订单成功",200,$data);
    }


}