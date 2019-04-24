<?php

namespace app\admin\controller;

use app\service\LinkService;

/**
 * 友情链接
 */
class Link extends Common
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
     * [Index 列表]
     */
	public function Index()
	{
		// 获取导航列表
		$data = LinkService::LinkList();
		$this->assign('data_list', $data['data']);

		// 是否新窗口打开
		$this->assign('common_is_new_window_open_list', lang('common_is_new_window_open_list'));

		// 是否启用
		$this->assign('common_is_enable_list', lang('common_is_enable_list'));

		return $this->fetch();
	}

	/**
	 * [Save 数据保存]
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
        return LinkService::LinkSave($params);
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
        return LinkService::LinkDelete($params);
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
        return LinkService::LinkStatusUpdate($params);
	}
}
?>