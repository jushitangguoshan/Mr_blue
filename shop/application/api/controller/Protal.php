<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/12 0012
 * Time: 17:28
 */

namespace app\api\controller;
use think\Db;

class Protal extends Common
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
     * 用户个人信息
     */
    public function personal()
    {

        $id = $this->user['id'];
        $data = Db::name("user")->field("nickname,pwd,mobile,email")->select($id);
        $protection = Db::name("user_protection")->where(["user_id"=>$id])->select();
        $count = 0;
        if(!empty($data[0]['pwd'])) $count += 20;
        if(!empty($data[0]['mobile'])) $count += 20;
        if(!empty($data[0]['email'])) $count += 20;
        if(!empty($protection)) $count += 20;

        if($count == 20){
            $data[0]['protection'] = "较低";
        }else if($count == 40){
            $data[0]['protection'] = "正常";
        }else if($count == 60){
            $data[0]['protection'] = "较高";
        }else if($count == 80){
            $data[0]['protection'] = "很高";
        }else if($count == 100){
            $data[0]['protection'] = "绝对安全";
        }
        unset($data['pwd']);
        return DataReturn("success",200,$data);
    }

    /**
     * 用户记录
     */
    public function userRecord()
    {
        //$id = '77';
        $params['user'] = $this->user;
        $id = $params['user']['id'];
        $data['stay_payment'] = Db::name("order")->field("count(*) as count,id,status")->where("user_id",$id)->where("status",1)->select();
        $data['stay_deliverGoods'] = Db::name("order")->field("count(*) as count,id,status")->where("user_id",$id)->where("status",3)->select();
        $data['stay_evaluate'] = Db::name("order")->field("count(*) as count,id,status")->where("user_id",$id)->where("status",4)->select();
        $data['browse_goods'] = Db::name("goods_browse")->field("count(*) as count,user_id")->where("user_id",$id)->select();
        $data['like_goods'] = Db::name("user_likes_goods")->field("count(*) as count,user_id")->where("user_id",$id)->select();
        $data['collection'] = Db::name("goods_favor")->field("count(*) as count,user_id")->where("user_id",$id)->select();
        return DataReturn("success",200,$data);
    }

    /**
     * 账号安全遍历
     */
    public function accountSecurity()
    {
        $params['user'] = $this->user;
        $id = $params['user']['id'];
        //$id = "77";
        $data = Db::name("user")->field("id,pwd,email,mobile")->where("id",$id)->find();
        $protection = Db::name("user_protection")->where(["user_id"=>$id])->select();
        $count = 20;
        if(!empty($data['pwd'])) $count += 20;
        if(!empty($data['mobile'])) $count += 20;
        if(!empty($data['email'])) $count += 20;
        if(!empty($protection)) $count += 20;
        $data['fraction'] = $count;
        if($count == 20){
            $data['protection'] = 4;
        }else if($count == 40){
            $data['protection'] = 3;
        }else if($count == 60){
            $data['protection'] = 2;
        }else if($count == 80){
            $data['protection'] = 1;
        }else if($count == 100){
            $data['protection'] = 0;
        }
        unset($data['pwd']);
        return DataReturn("success",200,$data);
    }


    /**
     *
     */
    public function userPerson()
    {
        $params = input();
        $params['user'] = $this->user;
        $data = Db::name("user")->where(["id"=>$params['user']['id']])->select();
        return DataReturn("success",200,$data);
    }

    /*
     * 用户个人信息修改
     */
    public function updPersonal()
    {
        $params = input();
        $params['user'] = $this->user;
        //$id = $params['user']['id'];
        //$params = ["nickname"=>"李四"];
        if(!empty($params)){
            $data = Db::name("user")->where("id",$params['user']['id'])->update($params);
            if(!$data){
                return DataReturn("修改失败",-400);
            }
            return DataReturn("success",200);
        }
    }


    /**
     * 为我推荐品牌列表
     */
    public function recommended()
    {
        $params = input();
        $params['user'] = $this->user;
        $where['user_id'] = $params['user']['id'];
        $count = Db::name("order")->where($where)->count();
        //$count = 0;
        if($count){
            $data = Db::name("order_goods")->alias("og")->field("g.brand_id")->join("goods g","g.id = og.goods_id","left")->where($where)->select();
            $arr = [];
            foreach($data as $val){
                if($val['brand_id'] != ""){
                    $arr[] = $val['brand_id'];
                }
            }

            $id = implode(",",array_unique($arr));
            $data = Db::name("brand")->field("id,logo,name")->where("id in ($id)")->select();
            foreach($data as $key => $val){
                $data[$key]['goods_count'] = Db::name("goods")->where("brand_id",$val['id'])->count();
            }
        }
     return DataReturn("success",200,$data);
    }

    /**
     * 为我推荐品牌详细
     */
    public function brandDetails()
    {
        $params = input();
        $params['brand_id'] = 3;
        $params["user"] = $this->user;
        $where = ["brand_id"=>$params["brand_id"]];
        $total = Db::name("goods")->where($where)->count();
        $number = empty($params["number"]) ? 10 : $params["number"];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);
        $order_by = empty($params['order_by']) ? 'id desc' : $params['order_by'];
        $field = "id,title,describe,images,original_price,price";
        $data = Db::name("goods")
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
}