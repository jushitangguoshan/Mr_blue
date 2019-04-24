<?php

namespace app\admin\controller;

use app\service\ConfigService;

/**
 * 手机端 - 配置
 */
class AppConfig extends Common
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
     * [Index 配置列表]
     */
	public function Index()
	{
		// 配置信息
		$this->assign('data', ConfigService::ConfigList());

		// 是否
		$this->assign('common_is_text_list', lang('common_is_text_list'));
		
		return $this->fetch();
	}

	/**
	 * [Save 配置数据保存]
	 */
	public function Save()
	{
		return ConfigService::ConfigSave($_POST);
	}
}
?>