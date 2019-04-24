<?php

namespace app\admin\controller;

use app\service\ConfigService;

/**
 * 邮箱设置
 */
class Email extends Common
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
		$type = input('type', 'email');

		// 导航
		$this->assign('nav_type', $type);
		if($type == 'email')
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

	/**
	 * [EmailTest 邮件测试]
	 */
	public function EmailTest()
	{
		// 验证码公共基础参数
		$verify_param = array(
				'expire_time' => MyC('common_verify_expire_time'),
				'time_interval'	=>	MyC('common_verify_time_interval'),
			);

		$obj = new \base\Email($verify_param);
		$email_param = array(
				'email'		=>	input('email'),
				'content'	=>	'邮件配置-发送测试内容',
				'title'		=>	MyC('home_site_name').' - '.'测试',
			);
		// 发送
		if($obj->SendHtml($email_param))
		{
			return DataReturn('发送成功');
		}
		return DataReturn('发送失败'.'['.$obj->error.']', -100);
	}
}
?>