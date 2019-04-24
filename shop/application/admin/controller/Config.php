<?php

namespace app\admin\controller;

use app\service\ConfigService;

/**
 * 配置设置
 */
class Config extends Common
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
		//$this->IsPower();
	}

	/**
     * [Index 配置列表]
     */
	public function Index()
	{
		// csv
		$this->assign('common_excel_charset_list', lang('common_excel_charset_list'));

		// 扣除库存规则
		$this->assign('common_deduction_inventory_rules_list', lang('common_deduction_inventory_rules_list'));

		// 是否
		$this->assign('common_is_text_list', lang('common_is_text_list'));

		// 热门搜索关键字
		$this->assign('common_search_keywords_type_list', lang('common_search_keywords_type_list'));

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