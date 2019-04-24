<?php

namespace app\admin\controller;

use app\service\ConfigService;

/**
 * 短信设置
 */
class Sms extends Common
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

		// 导航
		$type = input('type', 'sms');
		$this->assign('nav_type', $type);
		if($type == 'sms')
		{
			return $this->fetch('index');
		} else {
			return $this->fetch('message');
		}
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