<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/17 0017
 * Time: 10:58
 */

namespace app\api\controller;


use app\service\GoodsService;
use app\service\OrderService;
use think\Db;

class Orderlist extends Common
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

        //判断是否登入
        $this->Is_Login();
    }

    /**
     * 我的订单列表
     */
    public function index()
    {
        // 参数
        $params = input();
        $params['user'] = $this->user;
        // 分页
        $number = empty($params['number']) ? 10 : $params['number'];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        //$page = max(1, isset($this->data_post['page']) ? intval($this->data_post['page']) : 1);
        // 条件
        //$where = GoodsService::UserOrderListWhere($params);
        // 获取总数
        $where = [
            ['o.is_delete_time', '=', 0]
        ];
        $where[] = ['o.user_id', '=', $params['user']['id']];
        //状态查询
        if(!empty($params['status'])){
            $where[] = ['o.status',"=",$params['status']];
        }
        //搜索查询
        if(!empty($params['keywords']))
        {
            $where[] = ['o.order_no|g.title', 'like', '%'.$params['keywords'].'%'];
            //$where[] = ['', 'like', '%'.$params['keywords'].'%'];
        }
        $total = Db::name("order_goods")
            ->alias("og")
            ->join("order o","o.id = og.order_id","left")
            ->join("goods g","g.id = og.goods_id","left")
            ->where($where)
            ->group("og.order_id")
            ->count();
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);

        // 获取列表
        $data_params = array(
            'm'   => $start,
            'n'  => $number,
            'where'         => $where,
        );
        if(empty($params['keywords'])){
            $data = GoodsService::MyOrderList($data_params);
            $data = $data['data'];
        }else{
            $filed = "o.id,o.order_no,o.status,o.add_time,o.payment_id";
            $data = Db::name("order_goods")
                ->alias("og")
                ->field($filed)
                ->join("goods g","og.goods_id = g.id","left")
                ->join("order o","o.id = og.order_id","left")
                ->where($where)
                ->select();
            foreach($data as &$val){
                $val['name'] = Db::name("payment")->where("id",$val['payment_id'])->value("name");
                $val['nickname'] = $this->user['nickname'];
                $val['goods_son'] = Db::name("order_goods")
                                ->alias("og")
                                ->field('g.id,g.images,g.price,g.title,og.goods_number')
                                ->join("goods g","og.goods_id = g.id","left")
                                ->join("order o","o.id = og.order_id","left")
                                ->where("o.order_no",$val['order_no'])
                                ->select();
            }
        }
        // 返回数据
        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data,
        ];
        if(!empty($result['data'])){
            $result['count']["stay_payment"] = Db::name("order")->where("status",1)->count();
            $result['count']["stay_receiving"] = Db::name("order")->where("status",3)->count();
            $result['count']["Closed"] = Db::name("order")->where("status",6)->count();
        }else{
            $result['count']["stay_payment"] = 0;
            $result['count']["stay_receiving"] = 0;
            $result['count']["Closed"] = 0;
        }
        return DataReturn('success', 200, $result);
    }

    /**
     * 订单详情
     */
    public function orderDetail()
    {
        $params = input();

        //$params["order_no"] = "15520165153215";
        if(empty($params)){
            return DataReturn("请传参");
        }
        $params["user"] = $this->user;
        $where = ["o.user_id"=>$params['user']['id'],"o.order_no"=>$params['order_no']];
        $data = Db::name("order")
            ->alias("o")
            ->field("o.id as order_id,o.total_price,o.order_no,o.status,o.pay_time,o.confirm_time,o.delivery_time,o.collect_time,o.add_time as order_time,p.name as payment_name,ua.*")
            ->join("user_address ua","ua.id = o.receive_address_id","left")
            ->join("payment p","p.id = o.payment_id","left")
            ->where($where)
            ->find();
        $address_list = Db::name("user_address")->select();
         if($data['country'] == 1){
             $data['province_name'] = Db::name("area")->where(['area_id'=>$data['province']])->value("area_name");
             $data['city_name'] = Db::name("area")->where(['area_id'=>$data['city']])->value("area_name");
             $data['county_name'] = Db::name("area")->where(['area_id'=>$data['county']])->value("area_name");
         }
        $data['country_name'] = Db::name("country")->where(['id'=>$data['country']])->value("country_name");
        if($data['status'] == '7'){
            $arr = Db::name("order_refund")->field("application_time,audit_time,reject_cause,close_time")->where("order_no",$data["order_no"])->find();
            $data['application_time'] = $arr['application_time'];
            $data['audit_time'] = $arr['audit_time'];
            $data['reject_cause'] = $arr['reject_cause'];
            $data['close_time'] = $arr['close_time'];
        }
        $data['goods_son'] = Db::name("order_goods")->alias("og")->field("g.title,g.images,og.goods_number,og.goods_prive")->join("goods g","g.id = og.goods_id")->where(["og.order_id"=>$data['order_id']])->select();

        if(empty($data)){
            return DataReturn("当前没有交易订单。");
        }
        $this->assign("address_list",$address_list);
        return DataReturn('处理成功', 200, $data);

    }

    /**
     * [Cancel 订单取消]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-05-21T10:48:48+0800
     */
    public function Cancel()
    {
        $params = $this->data_post;
        $params['user_id'] = $this->user['id'];
        $params['creator'] = $this->user['id'];
        $params['creator_name'] = $this->user['user_name_view'];
        return OrderService::OrderCancel($params);
    }

    /**
     * [Collect 订单收货]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-05-21T10:48:48+0800
     */
    public function Collect()
    {
        $params = $this->data_post;
        $params['user_id'] = $this->user['id'];
        $params['creator'] = $this->user['id'];
        $params['creator_name'] = $this->user['user_name_view'];
        return OrderService::OrderCollect($params);
    }

    /**
     * 订单删除
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-30
     * @desc    description
     */
    public function Delete()
    {
        $params = $this->data_post;
        $params['user_id'] = $this->user['id'];
        $params['creator'] = $this->user['id'];
        $params['creator_name'] = $this->user['user_name_view'];
        $params['user_type'] = 'user';
        return OrderService::OrderDelete($params);
    }

    /**
     * 申请退款
     */
}