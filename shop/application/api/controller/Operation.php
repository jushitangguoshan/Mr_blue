<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2019 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\api\controller;
use think\Db;
use think\Request;

/**
 * 用户地址
 */
class Operation extends Common
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
     * 优惠券列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function CouponList()
    {
        $id = $this->user;
        $data = Db::name("goods_coupon")
            ->alias("gc")
            ->where('gc.user_id',"eq",$id['id'])
            ->join("cms_coupons g","gc.coupon_id = g.coupon_type")
            ->order("gc.id DESC")
            ->field("g.*,gc.*")
            ->select();
        return DataReturn("success",200,$data);
    }

    //根据时间获取某个时间段的数据
    public function GetSeckillList(Request $request){
        if($request->isPost()){
            if($request->post('start_time') == null) return json(['code'=>500,'msg'=>'数据错误！']);
            $start = substr($request->post("start_time"),0,-3);
            $data = Db::name('goods')->alias('g')
                ->join('GoodsPromotion gp','g.id=gp.goods_id')
                ->field('g.id,g.title,g.describe,g.images,gp.id as gp_id,gp.goods_price,gp.goods_activity_price,gp.goods_number,gp.goods_status,gp.goods_buy_number,gp.goods_upper_time,gp.goods_lower_time')
                ->where('gp.goods_upper_time',$start)
                ->select();
            if(empty($data)) return json(['code'=>200,'msg'=>'请求成功但没有数据','data'=>$data]);
            return json(['code'=>200,'msg'=>'数据请求成功！','data'=>$data]);
        }
        return json(['code'=>500,'msg'=>'请求出错了！']);
    }

    //抢购时间列表
    public function GetTimeList(){
        $data = [
            0=>$this->getMsecTime(strtotime(date('Y-m-d')."08:00:00")),
            1=>$this->getMsecTime(strtotime(date('Y-m-d')."10:00:00")),
            2=>$this->getMsecTime(strtotime(date('Y-m-d')."12:00:00")),
            3=>$this->getMsecTime(strtotime(date('Y-m-d')."14:00:00")),
            4=>$this->getMsecTime(strtotime(date('Y-m-d')."16:00:00")),
            5=>$this->getMsecTime(strtotime(date('Y-m-d')."18:00:00")),
            6=>$this->getMsecTime(strtotime(date('Y-m-d')."20:00:00"))
        ];
        return json(['code'=>200,'msg'=>'数据请求成功','data'=>$data]);
    }

    public function getMsecTime($sec)
    {
        list($msec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime;
    }

    //获取明天第一场
    public function GetTomList(Request $request){
        if($request->isGet()){
            $tom = date("Y-m-d",strtotime("+1 day"));
            $tom = strtotime($tom);
            $data = Db::name('goods')->alias('g')
                ->join('GoodsPromotion gp','g.id=gp.goods_id')
                ->field('g.id,g.title,g.describe,g.images,gp.id as gp_id,gp.goods_price,gp.goods_activity_price,gp.goods_number,gp.goods_status,gp.goods_buy_number,gp.goods_upper_time,gp.goods_lower_time')
                ->where('gp.goods_upper_time','=',$tom)
                ->whereOr('gp.goods_upper_time','>',$tom)
                ->order('gp.goods_upper_time','asc')
                ->select();
            if(empty($data)) return json(['code'=>200,'msg'=>'请求成功但没有数据','data'=>$data]);
            return json(['code'=>200,'msg'=>'数据请求成功！','data'=>$data]);
        }
        return json(['code'=>500,'msg'=>'请求出错了！']);
    }
}
?>