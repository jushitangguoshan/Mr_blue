<?php

namespace app\index\controller;

use app\service\BannerService;
use app\service\GoodsService;
use app\service\ArticleService;
use app\service\OrderService;
use app\service\Talk;

/**
 * 首页
 */
class Index extends Common
{
    /**
     * 构造方法
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function Index()
    {
        // 首页轮播
        $this->assign('banner_list', BannerService::Banner());

        // 楼层数据
        $this->assign('goods_floor_list', GoodsService::HomeFloorList());

        // 新闻
        $params = [
            'where' => ['a.is_enable'=>1, 'a.is_home_recommended'=>1],
            'field' => 'a.id,a.title,a.title_color,ac.name AS category_name',
            'm' => 0,
            'n' => 9,
        ];
        $article_list = ArticleService::ArticleList($params);
        $this->assign('article_list', $article_list['data']);

        // 用户订单状态
        $user_order_status = OrderService::OrderStatusStepTotal(['user_type'=>'user', 'user'=>$this->user, 'is_comments'=>1]);
        $this->assign('user_order_status', $user_order_status['data']);
        
        return $this->fetch();
    }

    public function talk(){
        return $this->fetch();
    }
}
?>