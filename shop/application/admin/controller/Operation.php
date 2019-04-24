<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26 0026
 * Time: 19:11
 */

namespace app\admin\controller;

use app\service\OperationService;
use think\Db;

class Operation extends Common
{
    /**
     * 促销商品的（条件）渲染
     */
    public function index()
    {
        $params = input();
        $post = [];
        if(!empty($params)){
            foreach($params as $key => $val){
                if($val != ""){
                    if($key == "seckill_stime" || $key == "add_time"){
                        $post[] = [$key,">=",strtotime($val)];
                    }else if($key == "seckill_etime"){
                        $post[] = [$key,"=<",strtotime($val)];
                    }else if($key == "end_time"){
                        $post[] = ["add_time","<=",strtotime($val)];
                    }else{
                        $post[] = [$key,"=",$val];
                    }
                }
            }
            $data = Db::name("goods")->where($post)->where("is_seckill",0)->where("is_shelves",1)->order("sort desc")->select();
        }else{
            $data = Db::name("goods")->where("seckill_status in (0,2)")->where("is_seckill",0)->where("is_shelves",1)->order("sort desc")->select();//->limit(10)
        }
        foreach($data as$key => $val){
            $data[$key]['seckill_stime'] = date("Y-m-d H:i",$data[$key]['seckill_stime']);
            $data[$key]['seckill_etime'] = date("Y-m-d H:i",$data[$key]['seckill_etime']);
            $data[$key]['add_time'] = date("Y-m-d H:i:s",$data[$key]['add_time']);
            $data[$key]['upd_time'] = date("Y-m-d H:i:s",$data[$key]['upd_time']);
        }
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 活动商品页面
     */
    public function Activity()
    {
        $params = input();
        $post = [];
        $time = time();
        if(!empty($params)){
            $arr = Db::name("goods")->where($params)->select();
            foreach($params as $key => $val){
                if($val != ""){
                    if($key == "seckill_stime" || $key == "add_time"){
                        $post[] = [$key,">=",strtotime($val)];
                    }else if($key == "seckill_etime"){
                        $post[] = [$key,"<=",strtotime($val)];
                    }else if($key == "end_time"){
                        $post[] = ["add_time","<=",strtotime($val)];
                    }else{
                        $post[] = [$key,"=",$val];
                    }
                }
            }
            $data = Db::name("goods")->where($post)->where("is_seckill",1)->where("is_shelves",1)->order("sort desc")->select();
        }else{
            $data = Db::name("goods")->where("seckill_status in (1,3)")->where("is_seckill",1)->where("is_shelves",1)->order("sort desc")->select();//->limit(10)
            foreach($data as $key => $val){
                if($val['seckill_etime'] <= $time){
                    $data[$key]['seckill_status'] = 3;
                }
            }
        }
        foreach($data as$key => $val){
            $data[$key]['seckill_stime'] = date("Y-m-d H:i",$data[$key]['seckill_stime']);
            $data[$key]['seckill_etime'] = date("Y-m-d H:i",$data[$key]['seckill_etime']);
            $data[$key]['add_time'] = date("Y-m-d H:i:s",$data[$key]['add_time']);
            $data[$key]['upd_time'] = date("Y-m-d H:i:s",$data[$key]['upd_time']);
        }

        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 促销商品增加页面
     */
    /*public function addPage()
    {
        $params = input();
        if(!empty($params)){

            if($params['goods_name'] == ""){
                return DataReturn('商品名不能为空', 304);
            }
            if($params['goods_number'] <= 0){
                return DataReturn('商品库存不能小于0', 304);
            }
            if($params['goods_upper_time'] == "" || $params['seckill_etime'] == ""){
                return DataReturn('抢购开始或结束时间不能为空', 304);
            }
            $params['seckill_stime'] = strtotime($params['seckill_stime']);
            $params['seckill_etime'] = strtotime($params['seckill_etime']);
            if($params['seckill_stime'] > $params['seckill_etime']){
                return DataReturn("结束时间不能小于抢购时间",304);
            }
            $params['add_time'] = time();
            if(Db::name("goods")->insert($params)){
                return DataReturn('增加成功', 0);
            }
            return DataReturn('增加失败', 304);
        }
        return $this->fetch();
    }
*/
   /*
     * 活动商品编辑
     */
        public function updateShop()
       {
           $params = input();
           $count = count($params);
           if($count > 1){
               if($params['title'] == ""){
                   return DataReturn('商品标题不能为空', 304);
               }
               if($params['buy_min_number'] <= 0){
                   return DataReturn('最低购买数量不能小于1', 304);
               }
               if($params['seckill_stime'] == "" || $params['seckill_etime'] == ""){
                   return DataReturn('抢购时间不能为空', 304);
               }
               if($params['seckill_status'] == "审核中"){
                   $params['seckill_status'] = 0;
               }else if($params['seckill_status'] == "已通过"){
                   $params['seckill_status'] = 1;
               }else if($params['seckill_status'] == "已拒绝"){
                   $params['seckill_status'] = 2;
               }else{
                   $params['seckill_status'] = 3;
               }
               if(empty($params['buy_max_number'])){
                   $params['buy_max_number'] = 0;
               }
               $params['seckill_stime'] = strtotime($params['seckill_stime']);
               $params['seckill_etime'] = strtotime($params['seckill_etime']);
               if($arr = Db::name("goods")->where(["id"=>$params['id']])->update($params)){
                   $logs = [
                       'admin_id'=>$this->admin['id'],
                       'title'=>'修改',
                       'detail'=>$this->admin['username'].'修改了活动商品'.$params['title'],
                       'add_time'=>time()
                   ];
                   System::AdminLogSave($logs);
                   return DataReturn('修改成功', 0);
               }
               return DataReturn('修改失败', 304);
           }
           $data = Db::name("goods")->where($params)->select();
           $data[0]['seckill_stime'] = date("Y-m-d",$data[0]['seckill_stime']);
           $data[0]['seckill_etime'] = date("Y-m-d",$data[0]['seckill_etime']);
           $this->assign("data",$data[0]);
           return $this->fetch();
       }
       /**
        * 活动商品删除
        */
    public function deleteShop()
    {
        $params = input();
        if(!empty($params)){
            $data = Db::name("goods")->field("goods_status")->where($params)->select();
            if($data[0]['goods_status'] == 2){
                $this->success('删除失败');
            }else{
                Db::name("goods")->where($params)->delete();
                $logs = [
                    'admin_id'=>$this->admin['id'],
                    'title'=>'删除',
                    'detail'=>$this->admin['username'].'删除了促销商品'.$params['id'],
                    'add_time'=>time()
                ];
                $log = System::AdminLogSave($logs);
                $this->error('删除成功');
            }
        }
    }

    /**
     * 促销商品审核
     */
    public function examineShop()
    {
        $params = input();
        $count = count($params);

        if($count > 1){
            Db::startTrans();
            try{
                $params['goods_upper_time'] = strtotime($params['goods_upper_time']);
                $params['goods_lower_time'] = strtotime($params['goods_lower_time']);
                if(!Db::name("GoodsPromotion")->where(['id'=>$params['p_id']])->update(["goods_upper_time"=>$params['goods_upper_time'],'goods_lower_time'=>$params['goods_lower_time']])){
                    return DataReturn('审核失败', 304);
                }
                if(!Db::name("goods")->where(['id'=>$params['id']])->where("is_shelves",1)->update(["seckill_status"=>1])){
                    return DataReturn('审核失败', 304);
                }
                if(!Db::name("goods")->where(['id'=>$params['id']])->where("is_shelves",1)->update(["is_seckill"=>1])){
                    return DataReturn('审核失败', 304);
                }
                Db::commit();
            } catch (\Exception $e) {
                Db::rollback();
            }
            $logs = [
                'admin_id'=>$this->admin['id'],
                'title'=>'通过',
                'detail'=>$this->admin['username'].'通过了商品'.$params['id']."的审核",
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            return DataReturn('审核通过', 0);
        }else{
            $data = Db::name("goods")->alias('g')
                ->field('g.id,g.title,gp.id as p_id,gp.goods_id,gp.goods_name,gp.goods_activity_price,gp.goods_price,gp.goods_number,gp.goods_upper_time,gp.goods_lower_time,gp.add_time,gp.goods_status')
                ->join('GoodsPromotion gp','g.id=gp.goods_id')
                ->where('g.id',$params['id'])->find();
            $data['goods_lower_time'] = date('Y-m-d H:00:00',$data['goods_lower_time']);
            $data['goods_upper_time'] = date('Y-m-d H:00:00',$data['goods_upper_time']);
            $this->assign("data",$data);
            return $this->fetch();
        }
        /*if(!empty($params)){
            if(!Db::name("goods_promotion")->where($params)->update(["goods_status"=>1])){
                $this->success('审核失败');
            }
            $this->error('审核通过');
        }*/
    }

    /**
     * 促销商品审核拒绝
     */
    public function refuseShop()
    {
        $params = input();
        if(!empty($params)){
            if(!Db::name("goods")->where($params)->update(['seckill_status'=>2])){
                $this->success('拒绝失败');
            }
            $logs = [
                'admin_id'=>$this->admin['id'],
                'title'=>'拒绝',
                'detail'=>$this->admin['username'].'拒绝了商品'.$params['id']."的审核",
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            $this->error('拒绝成功');
        }
    }



    /**
     * 优惠卷管理页面
     */
    public function Coupon()
    {

        $params = input();
        //var_dump($params);

        if($data = Db::name("goods_coupon")->select()){
            foreach($data as $key => $val){
                if(($val['add_time'] + $val['effective_time'] < time()) && ($val['status'] != 4)){
                    Db::name("goods_coupon")->where(['id'=>$val['id']])->update(["status"=>3]);
                }
            }
        }
        $coupon = [];
        $user = [];
        foreach($params as $key => $val){
            if($val != ""){
                if($key == "status"){
                    $coupon['status'] = $params[$key];
                }elseif($key == "username"){
                    $user['username'] = $params[$key];
                }
            }
        }
        $data = Db::name("goods_coupon")->where($coupon)->select();
        $user = Db::name("user")->where($user)->select();
        //类别
        $mark = Db::name("goods_category")->field("id,name")->select();
        foreach($data as $key => $val){
            $data[$key]['add_time'] = date("Y-m-d h:i:s",$val['add_time']);

        }
        $this->assign("data",$data);
        $this->assign("mark",$mark);
        $this->assign("user",$user);
        return $this->fetch();
    }

    /**
     * 优惠卷增加页面
     */
    public function addCoupon()
    {
        $params = input();
        if(!empty($params)){
            $data = Db::name("goods_coupon")->where($params)->select();
            $this->assign('data',$data[0]);
        }else{

        }
        return $this->fetch();
    }


    /**
     * 优惠卷软删除
     */
    /*public function delCoupon()
    {
        $params = input();
        if(!empty($params)){
            if(!Db::name("goods_coupon")->where($params)->update(['status'=>4])){
                return $this->error("删除失败");
            }
            if(!Db::name("goods_coupon")->where($params)->update(['status'=>4])){
                return $this->error("删除失败");
            }
            return $this->success("删除成功");

        }
    }*/
    /**
     * 优惠卷删除
     */
    public function delCoupon()
    {
        $params = input();
        if(!empty($params)){
            if(!Db::name("goods_coupon")->where($params)->delete()){
                return $this->error("删除失败");
            }
            return $this->success("删除成功");
        }
    }

    /**
     * 优惠卷处理（增加，发配）
     */
    public function updCoupon()
    {
        $params = input();
        $count = count($params);
        //var_dump($params);
        if($count > 2){
            $id = [];
            if(!empty($params['username'])){
                $id = Db::name("user")->field("id")->where(['username'=>$params['username']])->select();
            }
            if(!empty($id)){
                $params['user_id'] = $id[0]['id'];
            }else{
                unset($params['username']);
                $params['user_id'] = 0;
            }
            if(empty($params['effective_time'])){
                $params['effective_time'] = 3*3600*24;
            }else{
                $params['effective_time'] = $params['effective_time']*3600*24;
            }
            $params['add_time'] = time();
            if(!Db::name("goods_coupon")->insert($params)){
                return $this->success("增加失败");
            }
            return $this->error("增加成功");
        }else{
            if(!empty($params['username'])){
                $id = Db::name("user")->field("id")->where(['username'=>$params['username']])->select();
                if(!Db::name("goods_coupon")->where(['id'=>$params['id']])->update(['user_id'=>$id[0]['id']])){
                    return $this->success("发配失败");
                }
                Db::name("goods_coupon")->where(['id'=>$params['id']])->update(['status'=>1]);
                return $this->error("发配成功");
            }
        }
        return $this->fetch();
    }

    /**
     * 抢购时间列表
     */
    public function TimeList(){
        $params = input();
        //var_dump($params);

        if($data = Db::name("goods_coupon")->select()){
            foreach($data as $key => $val){
                if(($val['add_time'] + $val['effective_time'] < time()) && ($val['status'] != 4)){
                    Db::name("goods_coupon")->where(['id'=>$val['id']])->update(["status"=>3]);
                }
            }
        }
        $coupon = [];
        $user = [];
        foreach($params as $key => $val){
            if($val != ""){
                if($key == "status"){
                    $coupon['status'] = $params[$key];
                }elseif($key == "username"){
                    $user['username'] = $params[$key];
                }
            }
        }
        $data = Db::name("goods_coupon")->where($coupon)->select();
        $user = Db::name("user")->where($user)->select();
        //类别
        $mark = Db::name("goods_category")->field("id,name")->select();
        foreach($data as $key => $val){
            $data[$key]['add_time'] = date("Y-m-d h:i:s",$val['add_time']);

        }
        $this->assign("data",$data);
        $this->assign("mark",$mark);
        $this->assign("user",$user);
        return $this->fetch();
    }

    /**
     * 抢购时间列表
     */
    public function rushTimeList()
    {
        $data = Db::name("rush_time")->order("time","asc")->select();
        foreach($data as $key => $val){
            if($val['time'] >= 10){
                $data[$key]['time'] = $val['time'].":00";
            }else{
                $data[$key]['time'] = "0".$val['time'].":00";
            }
        }
        $this->assign("data",$data);


        return $this->fetch();
    }

    /*
     * 增加抢购时间
     */
    public function addRushTime()
    {
        $params = input();
        if(empty($params)){
            return $this->fetch();
        }
        $num = Db::name("rush_time")->where(['time'=>$params['time']])->find();
        if($num){
            return $this->success("该时间段已存在");
        }
        $params['add_time'] = time();
        $data = Db::name("rush_time")->insert($params);
        if(!$data){
            return $this->success("增加失败");
        }
        return DataReturn("增加成功");
    }

    /*
     * 删除抢购时间
     */
    public function delRushTime()
    {
        $params = input();
        if(empty($params['id'])){
            return DataReturn("参数有误");
        }
        $data = Db::name("rush_time")->delete($params['id']);
        if(!$data){
            return DataReturn("删除失败");
        }
        return DataReturn("删除成功");
    }

    /*
     * 修改启用状态
     */
    public function updRushTime()
    {
        $params = input();
        $data = Db::name("rush_time")->where(["id"=>$params['id']])->update(["is_enable"=>$params['state']]);
        if(!$data){
            return DataReturn("修改失败");
        }
        return DataReturn("修改成功");
    }

    /*
     * 积分兑换比例列表
     */
    public function exchangeProportion()
    {
        $data = Db::name("exchange_proportion")->select();
        $this->assign("data",$data);
        return $this->fetch();
    }

    /**
     * 积分兑换类型增加
     */
    public function addExchangeType()
    {
        $params = input();
        if(!empty($params)){
            $where = ["name"=>$params['name'],"is_enable"=>1];
            if(Db::name("exchange_proportion")->where($where)->count()){
                return DataReturn("该积分兑换类型已存在");
            }
            $data = Db::name("exchange_proportion")->insert($params);
            if( !$data ){
                return DataReturn("增加失败");
            }
            return DataReturn("增加成功");
        }
        return $this->fetch();
    }

    /**
     * 积分兑换启用状态修改
     */
    public function updExchangeStatus()
    {
        $params = input();
        if(empty($params["id"])){
            return DataReturn("参数有误");
        }
        if($params['state'] == 1){
            $name = Db::name("exchange_proportion")->where(['id'=>$params['id']])->value("name");
            if(Db::name("exchange_proportion")->where(['name'=>$name,"is_enable"=>$params['state']])->count()){
                return DataReturn("该积分兑换类型已存在");
            }
        }
        $data = Db::name("exchange_proportion")->where(['id'=>$params['id']])->update(['is_enable'=>$params['state']]);
        if(!$data){
            return DataReturn("修改失败");
        }
        return DataReturn("修改成功");
    }

    /**
     * 积分兑换类型删除
     */
    public function delExchangeType()
    {
        $params = input();
        if(empty($params['id'])){
            return DataReturn("参数有误");
        }
        $data = Db::name("exchange_proportion")->where("id",$params['id'])->delete();
        if(!$data){
            return DataReturn("删除失败");
        }
        return DataReturn("删除成功");
    }
}