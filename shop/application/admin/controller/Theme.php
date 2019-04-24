<?php

namespace app\admin\controller;

use app\service\ThemeService;
use app\service\ConfigService;

/**
 * 主题管理
 */
class Theme extends Common
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

		// 小导航
		$this->view_type = input('view_type', 'home');
	}

	/**
     * 列表
     */
	public function Index()
	{
		// 导航参数
		$this->assign('view_type', $this->view_type);

		if($this->view_type == 'home')
		{
			// 模板列表
			$this->assign('data_list', ThemeService::ThemeList());

			// 默认主题
			$theme = MyC('common_default_theme', 'default', true);
			$this->assign('theme', empty($theme) ? 'default' : $theme);
			return $this->fetch('index');
		} else {
			return $this->fetch('upload');
		}
	}

	/**
	 * 模板切换保存
	 */
	public function Save()
	{
		return ConfigService::ConfigSave(input());
	}

	/**
	 * [Delete 删除]
	 */
	public function Delete()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始处理
		return ThemeService::ThemeDelete(input());
	}

	/**
	 * [Upload 模板上传安装]
	 */
	public function Upload()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始处理
		return ThemeService::ThemeUpload(input());
	}
}
?>