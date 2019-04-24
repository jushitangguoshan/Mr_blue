<?php

namespace app\admin\controller;

use app\service\ConfigService;

/**
 * 支付宝小程序 - 配置
 */
class AppMiniAlipayConfig extends Common
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