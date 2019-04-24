<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/28 0028
 * Time: 15:48
 */

namespace app\admin\controller;


use think\Db;

    class Orderexchange extends Common
{
    /**
     * 换货页面展示
     */
    public function index()
    {
        $params = input();
        $post = [];
        if(!empty($params)){
            foreach($params as $key => $val){
                if($val != ""){
                    if($key == "add_time"){
                        $post[] = [$key,">",strtotime($val)];
                    }else if($key == "end_time"){
                        $post[] = ["add_time","<",strtotime($val)];
                    }else{
                        $post[] = [$key,"=",$val];
                    }
                }
            }
            $data = Db::name("order_exchange")->where($post)->select();
        }else{
            $data = Db::name("order_exchange")->select();
        }
        $this->assign("data",$data);
        return $this->fetch();
    }

    /*
     *换货详情页面
     */
    public function moreOrderexchange()
    {
        $params = input();
        if(!empty($params)){
            $data = Db::name("order_exchange_detail")->where(['exchange_id'=>$params['id']])->select();
            $this->assign("data",$data);
            return $this->fetch();
        }
    }

    /**
     * 换货审核通过
     */
    public function adoptExamine()
    {
        $params = input();
        if(!empty($params)){
            if(Db::name("order_exchange")->where($params)->update(['status'=>1])){
                $this->error("审核通过");
            }else{
                $this->success("操作失败");
            }
        }
    }
    /**
     * 换货审核拒绝
     */
    public function refuseExamine()
    {
        $params = input();
        if(!empty($params)){
            if(Db::name("order_exchange")->where($params)->update(['status'=>2])){
                $this->error("审核已拒绝");
            }else{
                $this->success("操作失败");
            }
        }
    }


    /**
     * 换货订单删除
     */
    public function deleteShop()
    {

        $params = input();
        //var_dump($this->admin['username']);
        $mark = true;
        if(!empty($params)) {
            if ($data = Db::name("order_exchange")->where($params)->select()) {
                if ($data[0]['status'] == 2 || $data[0]['status'] == 5 || $data[0]['status'] == 6) {
                    Db::startTrans();
                    $arr = Db::name("order_exchange")->where($params)->delete();
                    if(!$arr){
                       $mark = false;
                    }
                    $array = Db::name("order_exchange_detail")->where(["exchange_id"=>$params['id']])->delete();
                    if(!$array){
                        $mark = false;
                    }
                    if($mark){
                        Db::commit();
                        $logs = [
                            'admin_id'=>$this->admin['id'],
                            'title'=>'删除',
                            'detail'=>$this->admin['username'].'删除了换货订单'.$params['id'],
                            'add_time'=>time()
                        ];
                        $log = System::AdminLogSave($logs);
                        $this->error("删除成功");
                    }else{
                        Db::rollback();
                        $this->success("数据有误");
                    }
                    //return DataReturn("删除成功");
                } else {
                    $this->success("该状态下订单不能删除");
                    //return DataReturn("操作失败",403);
                }
            }
        }
    }

    }