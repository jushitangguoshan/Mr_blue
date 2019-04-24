<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/19 0019
 * Time: 09:35
 */

namespace app\api\controller;


use think\Db;

class Mypoints extends Common
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
        //$this->Is_Login();
    }

    /**
     * 我的积分
     */
    public function index()
    {
        $params = input();
        $params['user'] = $this->user;
        $where['id'] = $params['user']['id'];
        $data = Db::name("user")->field("id,integral")->where($where)->select();
        return DataReturn("success",200,$data);
    }
    /**
     * 积分来源、去处
     */
    public function integralSource()
    {
        $params = input();
        $params['user'] = $this->user;
        $where = ["user_id"=>$params['user']['id']];
        $where["type"] = $params["type"] == 0 ? $params["type"] : "1";
        $total = Db::name("user_integral_log")->where($where)->count();
        $number = empty($params["number"]) ? 10 : $params["number"];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);
        $order_by = empty($params['order_by']) ? 'id desc' : $params['order_by'];
        $field = "id,user_id,type,original_integral,new_integral,msg,add_time";
        $data = Db::name("user_integral_log")
            ->field($field)
            ->where($where)
            ->limit($start,$number)
            ->order($order_by)
            ->select();
        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data,
        ];
        return DataReturn("success",200,$result);
    }


    /**
     * 删除积分记录
     */
    public function delete()
    {
        $params = input();
        $params["user"] = $this->user;
        if(empty($params["id"])){
            return DataReturn("请传参");
        }
        $where['id'] =  $params['id'];
        $data = Db::name("user_integral_log")->where($where)->delete();
        if(!$data){
            return DataReturn("删除失败");
        }
        return DataReturn("删除成功");
    }
}