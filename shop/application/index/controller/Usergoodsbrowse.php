<?php

namespace app\index\controller;

use app\service\GoodsService;

/**
 * 用户商品浏览
 */
class UserGoodsBrowse extends Common
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
     * 商品浏览列表
     * @desc    description
     */
    public function Index()
    {
        // 参数
        $params = input();
        $params['user'] = $this->user;

        // 分页
        $number = 10;

        // 条件
        $where = GoodsService::UserGoodsBrowseListWhere($params);

        // 获取总数
        $total = GoodsService::GoodsBrowseTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('index/usergoodsbrowse/Goods'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = GoodsService::GoodsBrowseList($data_params);
        $this->assign('data_list', $data['data']);
        $this->assign('ids', empty($data['data']) ? '' : implode(',', array_column($data['data'], 'id')));

        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * 商品浏览删除
     * @desc    description
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始处理
        $params = input('post.');
        $params['user'] = $this->user;
        return GoodsService::GoodsBrowseDelete($params);
    }
}
?>