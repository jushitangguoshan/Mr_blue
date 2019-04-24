<?php

namespace app\admin\controller;

use app\service\BrandService;

/**
 * 品牌分类管理
 */
class BrandCategory extends Common
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
     * [Index 品牌分类列表]
     */
	public function Index()
	{
		// 是否启用
		$this->assign('common_is_enable_list', lang('common_is_enable_list'));

		return $this->fetch();
	}

	/**
	 * [GetNodeSon 获取节点子列表]
	 */
	public function GetNodeSon()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 开始操作
		return BrandService::BrandCategoryNodeSon(input());
	}

	/**
	 * [Save 品牌分类保存]
	 */
	public function Save()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 开始操作
		$params = input();
		$params['admin'] = $this->admin;
		return BrandService::BrandCategorySave($params);
	}

	/**
	 * [Delete 品牌分类删除]
	 */
	public function Delete()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return BrandService::BrandCategoryDelete($params);
	}
}
?>