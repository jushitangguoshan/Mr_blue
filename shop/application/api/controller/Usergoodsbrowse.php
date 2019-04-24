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
use think\Db;

/**
 * 用户商品浏览
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class UserGoodsBrowse extends Common
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
     * 商品浏览列表
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-10-09
     * @desc    description
     */
    public function Index()
    {
        // 参数
        $params = input();

        $params['user'] = $this->user;
        //$params['time'] = "2019-03-14";
        // 分页
        $number = empty($params['number']) ? 10 : $params['number'];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        //$page = max(1, isset($this->data_post['page']) ? intval($this->data_post['page']) : 1);

        // 条件
        $where = GoodsService::UserGoodsBrowseListWhere($params);

        // 获取总数
        $total = GoodsService::GoodsBrowseTotal($where);
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);

        // 获取列表
        $data_params = array(
            'm'   => $start,
            'n'  => $number,
            'where'         => $where,
        );
        $data = GoodsService::GoodsBrowseList($data_params);

        // 返回数据
        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data['data'],
        ];
        return DataReturn('success', 0, $result);
    }

    /**
     * 商品浏览删除
     * @author   Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2018-09-14
     * @desc    description
     */
    public function Delete()
    {
        $params = input();
        $params['user_id'] = $this->user['id'];
        return GoodsService::GoodsBrowseDelete($params);
    }


    /**
     * 浏览记录时间
     */
    public function recordTime()
    {

        $time = Db::name("goods_browse")->field("add_time")->group("add_time")->select();
        if(!$time){
            return DataReturn("暂无浏览商品");
        }
        $arr = [];
        foreach($time as $val){
            $arr[] = date("Y-m-d", $val['add_time']);
        }
        $data = [];
        $array = array_values(array_unique($arr));
        foreach($array as $key => $value){
            $data[] = strtotime($value);
        }

        return DataReturn("success",200,$data);
    }
}
?>