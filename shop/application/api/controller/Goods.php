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

use app\service\GoodsCommentService;
use app\service\GoodsService;
use function Couchbase\fastlzDecompress;
use think\Db;
use think\Request;

/**
 * 商品
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class Goods extends Common
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
     * 获取商品详情
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-12
     * @desc    description
     */
    public function Detail()
    {
        // 参数
        if(empty($this->data_post['goods_id']))
        {
            return DataReturn('参数有误', -1);
        }

        // 获取商品
        $goods_id = intval($this->data_post['goods_id']);
        $params = [
            'where' => [
                'id' => $goods_id,
                'is_delete_time' => 0,
            ],
            'is_photo' => true,
            'is_spec' => true,
            'is_content_app' => true,
        ];
        $goods = GoodsService::GoodsList($params);
        if(empty($goods[0]) || $goods[0]['is_delete_time'] != 0)
        {
            return DataReturn('商品不存在或已删除', -1);
        }
        unset($goods[0]['content_web']);

        // 当前登录用户是否已收藏
        $ret_favor = GoodsService::IsUserGoodsFavor(['goods_id'=>$goods_id, 'user'=>$this->user]);
        $goods[0]['is_favor'] = ($ret_favor['code'] == 0) ? $ret_favor['data'] : 0;

        // 商品访问统计
        GoodsService::GoodsAccessCountInc(['goods_id'=>$goods_id]);

        // 用户商品浏览
        GoodsService::GoodsBrowseSave(['goods_id'=>$goods_id, 'user'=>$this->user]);

        // 数据返回
        $result = [
            'goods'                     => $goods[0],
            'common_order_is_booking'   => (int) MyC('common_order_is_booking', 0),
        ];
        return DataReturn('success', 0, $result);
    }

    /**
     * 用户商品收藏
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-17
     * @desc    description
     */
    public function Favor()
    {
        // 登录校验
        $this->Is_Login();

        // 开始操作
        $params = $this->data_post;
        $params['user'] = $this->user;
        return GoodsService::GoodsFavor($params);
    }

    /**
     * 商品规格类型
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-14
     * @desc    description
     */
    public function SpecType()
    {
        // 开始处理
        $params = $this->data_post;
        return GoodsService::GoodsSpecType($params);
    }

    /**
     * 商品规格信息
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-14
     * @desc    description
     */
    public function SpecDetail()
    {
        // 开始处理
        $params = $this->data_post;
        return GoodsService::GoodsSpecDetail($params);
    }

    /**
     * 商品分类
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-12-14
     * @desc    description
     */
    public function Category()
    {
        // 开始处理
        $params = $this->data_post;
        $data = GoodsService::GoodsCategory($params);
        return DataReturn('success', 0, $data);
    }

    /**
     * 商品评论
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-07-18
     * @desc    description
     */
    public function GoodsComment()
    {
        // 参数
        $params = $this->data_post;
        $data = GoodsCommentService::GoodsCommentHtml($params);
        return DataReturn("success",200,$data);
    }

    /**
     * 搜索商品的国家列表
     */
    public function GetSeachState(Request $request){
        if($request->isGet()){
            $data = Db::name('Area')->field('area_id,area_name,area_parent_id')->where('area_id',33)->whereOr('area_parent_id',45055)->select();
            $arr = ['area_id'=>0,'area_name'=>"中国大陆",'area_parent_id'=>-1];
            array_unshift($data,$arr);
            return DataReturn('ok','200',$data);
        }
    }

    /**
     * 搜索商品的品牌列表
     */
    public function GetBrandList(Request $request){
        if($request->isGet()){
            $data = Db::name('Brand')->field('id,name,')->select();
            return DataReturn('ok','200',$data);
        }
        return DataReturn('请求出错','500');
    }

    /**
     * 搜索商品的分类列表
     */
    public function GetClassList(Request $request){
        if($request->isGet()){
            $class = Db::name('GoodsCategory')->where('pid',0)->where('is_enable',1)->field('id,pid,name')->select();
            $data = [];
            $data = $this->Recursion($class,$data);
            return DataReturn('ok','200',$data);
        }
        return DataReturn('请求出错','500');
    }

    //递归查询
    public function Recursion($class,&$data){
        foreach ($class as $k=>$v){
            $arr = Db::name('GoodsCategory')->field('id,pid,name')->where('is_enable',1)->where('pid',$v['id'])->select();
            if(count($arr) == 0){
                $data[] = $v;
            }else{
                $this->Recursion($arr,$data);
            }
        }
        return $data;
    }

    /**
     * 搜索商品
     */
    public function SeachGoods(){
        $params = input();
        $where = $this->SeachWhere($params);
        $sort = isset($params['sort']) ? $params['sort'] : 'sort';
        $order = isset($params['order']) ? "desc" : 'asc';
        // 总数
        $total =Db::name('Goods')->where(($where))->count();
        $field = 'id,title,describe,original_price,price';
        $page = isset($params['page']) ? intval($params['page']) : 1;
        $limit = isset($params['limit']) ? intval($params['limit']) : 2;
        $start = ($page -1) * $limit;
        $data = Db::name('Goods')->field($field)->where($where)->order($sort,$order)->limit($start, $limit)->select();
        return json(['msg'=>'ok','code'=>'200','data'=>$data,'total'=>$total,'page'=>$page]);
    }

    //条件过滤
    public function SeachWhere($params =[]){
        $where = [
            ['is_shelves', '=', 1],
            ['is_delete_time', '=', 0],
        ];

        // 国家
        if(!empty($params['state']))
        {
            $where[]= ['place_origin', '=', $params['state']];
        }

        if(!empty($params['class']))
        {
            $ids = Db::name('GoodsCategoryJoin')->where('category_id',$params['class'])->field('goods_id')->select();
            $where[] = ['id', 'in', $ids];
        }
        if(!empty($params['brand']))
        {
            $where[] = ['brand_id', '=', $params['brand']];
        }

        return $where;
    }

}
?>