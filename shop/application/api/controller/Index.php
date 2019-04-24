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

use app\service\GoodsService;
use app\service\BannerService;
use app\service\AppNavService;
use think\Db;

/**
 * 首页
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Index extends Common
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
	}

	/**
	 * 搜索框推荐
	 */
	public function searchRecommend()
	{
		$params = input();
		$limit = empty($params) ? 5 : ($params <= 10 ? $params : 10);
		$data = Db::name("goods")->field("id,title")->order("add_time desc")->limit($limit)->select();
		return DataReturn("success",200,$data);
	}

	/**
	 * 商品搜索查询
	 */
	public function search()
	{
		$params = input();
		/*$where = [["title","like","%".$params['data']."%"]];
		$data = Db::name("goods")->where($where)->select();*/
		$where = [["g.title","like","%".$params['data']."%"]];
		$data = Db::name("goods_category_join")->alias("gcj")->join("goods_category gc","gcj.category_id = gc.id")->join("goods g","gcj.goods_id = g.id")->where($where)->select();
		if(!$data){
			DataReturn("没有查到类似数据");
		}
		return DataReturn("success",200,$data);
	}

	/**
	 * 获取首页商品分类列
	 */
	public function index()
	{
		$where = ["is_enable"=>1];
		if(!$arr = Db::name("goods_category")->where($where)->select()){
			return DataReturn("暂无数据");
		}
		$data = generateTree($arr);
		return DataReturn('success',200,$data);
	}

	/**
	 * 首页轮播推荐
	 */
	public function wheelPlanting()
	{
		$data = Db::name("goods")->field("id,home_recommended_images")->where("is_home_recommended",1)->select();
		return DataReturn("success",200,$data);
	}

	/**
	 * 一键闪购
	 */
	public function Spike()
	{
		$where = ["is_seckill"=>1];
		if(!$data = Db::name("goods")->where($where)->select()){
			return DataReturn("暂无秒杀商品");
		}
		return DataReturn("success",200,$data);
	}

	/**
	 * 商品列表
	 */
	public function goodsList()
	{
		//$params = input();
		$params = ['data'=>"太阳能板"];
		if(empty($params)){
			return DataReturn("请传入参数");
		}
		$data = [];
		$where = ["name"=>$params['data']];
		$id = Db::name("goods_category")->where($where)->find();
		if($id){
			$son = Db::name("goods_category")->where(["pid"=>$id['id']])->select();
			if($son){
				$where = ["category_id"=>$son[0]['id']];
				$array = Db::name("goods_category_join")->field("goods_id")->where($where)->select();
				if($array){
					$arr = [];
					foreach($array as $val){
						$arr[] = $val['goods_id'];
					}
					$str = implode(",",$arr);
					$data = Db::name("goods")->where("id in ($str)")->select();
					if(!$data){
						return DataReturn("该分类没有商品");
					}
					foreach($son as $v){
						$data['son'][] = ["son_id"=>$v['id'],"son_name"=>$v['name']];
					}
					$data['pid'] = $id['id'];
				}
			}
		}
		if(!$data){
			return DataReturn("暂无数据");
		}
		return DataReturn("success",200,$data);
	}

	/**
	 * 商品列表分类
	 */
	public function goodsListClassify()
	{
		$params = input();
		//$params = ["data"=>"单晶"];
		if(empty($params['data'])){
			return DataReturn("请传入参数");
		}
		$where = ["name"=>$params['data']];
		$id = Db::name("goods_category")->field("id")->where($where)->find();
		if(!$id){
			return DataReturn("没有该分类");
		}
		$son = Config::goodsClassifyIsSon($id);
		if(!empty($son)){
			foreach($son as $val){
				$id[] = $val['id'];
			}
		}
		$str = implode(",",$id);
		$data = Db::name("goods_category_join")->where("category_id in ($str)")->select();
		if(!$data){
			return DataReturn("该分类没有商品");
		}
		$arr = [];
		foreach($data as $val ){
			$arr[] = $val['goods_id'];
		}
		$str = implode(",",$arr);
		$data = Db::name("goods")->where("id in ($str)")->select();
		if(!$data){
			return DataReturn("该分类没有商品");
		}
		return DataReturn("success",200,$data);
	}

	/**
	 * 为你推荐
	 */
	public function recommend()
	{
		/*session_start();
		$_SESSION['id'] = '77';*/
		$params = input();
		$field = empty($params) ? '*' : $params['data'];
		if(!empty($_SESSION['id'])){
			$id = $_SESSION['id'];
			$goods_id = Db::name("order")->field("goods_id")->where(["user_id"=>$id])->limit(1)->order("id desc")->select();
			$category_id = Db::name("goods_category_join")->field("category_id")->where(["goods_id"=>$goods_id[0]['goods_id']])->select();
			$category = [];
			foreach($category_id as $val){
				$category[] = $val["category_id"];
			}
			$category = implode(",",$category);
			$goods_id = Db::name("goods_category_join")->field("goods_id")->where("category_id in ($category)")->group("goods_id")->select();
			$category = [];
			foreach($goods_id as $val){
				$category[] = $val["goods_id"];
			}
			$category = implode(",",$category);
			$data = Db::name("goods")->field($field)->where("id in ($category)")->select();
			return DataReturn("success",200,$data);
		}else{
			//销量最高商品数据
			$data = Db::name("goods")->field("id,title,price")->where("is_home_recommended",1)->order("sales_count desc")->select();
			//最新发布商品数据
			//$data = Db::name("goods")->where("is_home_recommended",1)->field($field)->order("add_time desc")->select();

			foreach($data as $key => $val){
				$data[$key]['count'] = Db::name("goods_comment")->where("goods_id",$val['id'])->count();
			}
			return DataReturn("success",200,$data);
		}
	}

	/*
	 * 热评产品
	 */
	public function hotReview()
	{
		$data = Db::name("goods_comment")
			->alias("a")
			->field("a.content,b.nickname,c.id,c.title,c.images,c.price")
			->join("user b","a.user_id = b.id","left")
			->join("goods c","a.goods_id = c.id")
			->select();
		if( !$data ){
			return DataReturn("暂无数据");
		}
		return DataReturn("success",200,$data);
	}


	/**
	 * 获取用户IP地址
	 */
	public function userIp()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if(empty($ip)){
			return;
		}
		$time = time();
		$data = Db::name("user_ip")->where("ip",$ip)->select();
		if(!empty($data)){
			$count = $data[0]['count']+1;
			$params = ['count'=>$count,"upd_time"=>$time];
			$data = Db::name("user_ip")->where("ip",$ip)->update($params);
		}else{
			$params = ['ip'=>$ip,'add_time'=>$time];
			$data = Db::name("user_ip")->insert($params);
		}
		echo "<pre>";
		var_dump($data);
	}


	public function test()
	{

	}
}
?>