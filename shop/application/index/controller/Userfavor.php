<?php

namespace app\index\controller;

use app\service\GoodsService;

/**
 * 用户收藏
 */
class UserFavor extends Common
{
    /**
     * 构造方法
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->IsLogin();
    }
    
    /**
     * 商品收藏
     * @desc    description
     */
    public function Goods()
    {
        // 参数
        $params = input();
        $params['user'] = $this->user;

        // 分页
        $number = 10;

        // 条件
        $where = GoodsService::UserGoodsFavorListWhere($params);

        // 获取总数
        $total = GoodsService::GoodsFavorTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('index/userfavor/goods'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = GoodsService::GoodsFavorList($data_params);
        $this->assign('data_list', $data['data']);

        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * 商品收藏取消
     * @desc    description
     */
    public function Cancel()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始处理
        $params = input('post.');
        $params['user'] = $this->user;
        return GoodsService::GoodsFavor($params);
    }
}
?>