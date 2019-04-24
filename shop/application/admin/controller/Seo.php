<?php

namespace app\admin\controller;

use app\service\ConfigService;

/**
 * seo设置
 */
class Seo extends Common
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
		// url模式
		$this->assign('seo_url_model_list', lang('seo_url_model_list'));

		// 文章标题seo方案
		$this->assign('seo_article_browser_list', lang('seo_article_browser_list'));

		// 频道标题seo方案
		$this->assign('seo_channel_browser_list', lang('seo_channel_browser_list'));

		// 配置信息
		$this->assign('data', ConfigService::ConfigList());
		
		return $this->fetch();
	}

	/**
	 * [Save 配置数据保存]
	 */
	public function Save()
	{
		return ConfigService::ConfigSave(input());
	}
}
?>