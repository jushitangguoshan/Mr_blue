<?php

namespace app\admin\controller;

use app\service\CustomViewService;

/**
 * 自定义页面管理
 */
class CustomView extends Common
{
	/**
	 * 构造方法
	 */
	public function __construct()
	{
		// 调用父类前置方法
		parent::__construct();

		// 登录校验
		$this->IsLogin();

		// 权限校验
		$this->IsPower();
	}

	/**
     * [Index 文章列表]
     */
	public function Index()
	{
		// 参数
        $params = input();

        // 分页
        $number = 10;

        // 条件
        $where = CustomViewService::CustomViewListWhere($params);

        // 获取总数
        $total = CustomViewService::CustomViewTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/customview/index'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
            'field'     => '*',
        );
        $data = CustomViewService::CustomViewList($data_params);
        $this->assign('data_list', $data['data']);

		// 是否启用
		$this->assign('common_is_enable_list', lang('common_is_enable_list'));

		// 是否包含头部
		$this->assign('common_is_header_list', lang('common_is_header_list'));

		// 是否包含尾部
		$this->assign('common_is_footer_list', lang('common_is_footer_list'));

		// 是否满屏
		$this->assign('common_is_full_screen_list', lang('common_is_full_screen_list'));

		// 参数
        $this->assign('params', $params);
        return $this->fetch();
	}

	/**
	 * [SaveInfo 添加/编辑页面]
	 */
	public function SaveInfo()
	{
		// 参数
		$params = input();

		// 数据
		if(!empty($params['id']))
		{
			// 获取列表
	        $data_params = array(
	            'm'        => 0,
	            'n'        => 1,
	            'where'    => ['id'=>intval($params['id'])],
	            'field'    => '*',
	        );
	        $data = CustomViewService::CustomViewList($data_params);
	        $this->assign('data', empty($data['data'][0]) ? [] : $data['data'][0]);
		}

		// 是否启用
		$this->assign('common_is_enable_list', lang('common_is_enable_list'));

		// 是否包含头部
		$this->assign('common_is_header_list', lang('common_is_header_list'));

		// 是否包含尾部
		$this->assign('common_is_footer_list', lang('common_is_footer_list'));

		// 是否满屏
		$this->assign('common_is_full_screen_list', lang('common_is_full_screen_list'));

		return $this->fetch();
	}

	/**
	 * [Save 添加/编辑]
	 */
	public function Save()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        return CustomViewService::CustomViewSave($params);
	}

	/**
	 * [Delete 删除]
	 */
	public function Delete()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['user_type'] = 'admin';
        return CustomViewService::CustomViewDelete($params);
	}

	/**
	 * [StatusUpdate 状态更新]
	 */
	public function StatusUpdate()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        return CustomViewService::CustomViewStatusUpdate($params);
	}
}
?>