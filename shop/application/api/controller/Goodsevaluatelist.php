<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/17 0017
 * Time: 18:07
 */

namespace app\api\controller;


use app\service\GoodsService;
use think\Db;

class GoodsEvaluateList extends Common
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
     * 商品评价列表
     */
    public function index()
    {
        $params = input();
        $params['user'] = $this->user;
        $where[] = ["o.status","=","4"];
        $time = time()-(24*3600*90);
        if(empty($params['comments_status']) || $params['comments_status'] == 1){
            $where[] = ["o.user_is_comments","=",0];
        }else if($params['comments_status'] == 2){
           $where[] = ["o.user_is_comments","<>",0];
        }else if($params["comments_status"] == 3){
           $where[] = ["o.pay_time",">",$time];
        }
        $number = empty($params['number']) ? 10 : $params['number'];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        $total = GoodsService::SouOrderTotal($where);
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);
        $data_params = array(
            'm'   => $start,
            'n'  => $number,
            'where'         => $where,
        );
        $data = GoodsService::MyGoodsEvaluateList($data_params);

        // 返回数据
        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data['data'],
        ];
        //var_dump($result);
        return DataReturn('success', 200, $result);
    }


    /**
     * 去评论
     */
    public function goEvaluate()
    {
        $params = input();
        $params['user'] = $this->user;
        if(empty($params['data'])){
            return DataReturn("没有传商品id");
        }
        $data = Db::name("goods")->field("images,title,price")->where(["id"=>$params['data']])->select();
        if(!$data){
            return DataReturn("没有该商品");
        }
        return DataReturn("success",200,$data);
    }

    /**
     * 提交评价
     */
    public function saveEvaluate()
    {
        $params = input();

        if(empty($params)){
            return DataReturn("请传参");
        }
        $params['id'] = $this->user['id'];
        $data = Db::name("order_comments")->insert($params);
        if(!$data){
            return DataReturn("评价失败");
        }
        return DataReturn("success",200);
    }
}