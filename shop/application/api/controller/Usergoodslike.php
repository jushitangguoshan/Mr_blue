<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16 0016
 * Time: 15:56
 */

namespace app\api\controller;


use think\Db;

class Usergoodslike extends Common
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
     * 用户喜欢的商品列表
     */
    public function likeGoodsList()
    {
        $params = input();
        $params['user'] = $this->user;
        //$params['user']['id'] = "77";
        $params['brand_id'] = 3;
        $params["user"] = $this->user;
        $where = ["user_id"=>$params["user"]['id']];
        $total = Db::name("user_likes_goods")->where($where)->count();
        $number = empty($params["number"]) ? 10 : $params["number"];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);
        $order_by = empty($params['order_by']) ? 'id desc' : $params['order_by'];
        $field = "u.user_id,u.goods_id,u.add_time,g.title,g.original_price,g.price,g.images";
        $data = Db::name("user_likes_goods")
            ->alias("u")
            ->field("u.*,g.title, g.original_price, g.price, g.images")
            ->join("goods g","u.goods_id=g.id","left")
            ->where("u.user_id",$params['user']['id'])
            ->field($field)
            ->limit($start,$number)
            ->order($order_by)
            ->select();
        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data,
        ];
        if(!$data){
            return DataReturn("用户没有喜欢商品");
        }
        return DataReturn("success",200,$result);
    }

    /**
     * 取消喜欢的商品
     */
    public function delLikeGoods()
    {
        $params = input();
        $params['user'] = $this->user;
        if(empty($params['data'])){
            return DataReturn("没有该喜欢的商品");
        }
        /*$params['id'] = "1";
        $params['user']['id'] = "77";*/
        $where = ['user_id'=>$params['user']['id'],"goods_id"=>$params['data']];
        $data = Db::name("user_likes_goods")->where($where)->delete();
        if(!$data){
            return DataReturn("取消商品失败");
        }
        return DataReturn("取消商品成功",200,$data);
    }
}