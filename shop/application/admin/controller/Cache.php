<?php

namespace app\admin\controller;

/**
 * 缓存管理
 */
class Cache extends Common
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
	 * [Index 首页]
	 */
	public function Index()
	{
		// 缓存类型
		$this->assign('cache_type_list', lang('cache_type_list'));

		return $this->fetch();
	}

	/**
	 * [StatusUpdate 站点缓存更新]
	 */
	public function StatusUpdate()
	{
		// 模板 cache
		// 数据 temp
		\base\FileUtil::UnlinkDir(ROOT.'runtime'.DS.'cache');
		\base\FileUtil::UnlinkDir(ROOT.'runtime'.DS.'temp');
		return $this->success('更新成功');
	}

	/**
	 * [TemplateUpdate 模板缓存更新]
	 */
	public function TemplateUpdate()
	{
		// 模板 cache
		\base\FileUtil::UnlinkDir(ROOT.'runtime'.DS.'cache');

		return $this->success('更新成功');
	}

	/**
	 * [ModuleUpdate 模块缓存更新]
	 */
	public function ModuleUpdate()
	{
		return $this->success('更新成功');
	}

	/**
	 * [LogDelete 日志删除]
	 */
	public function LogDelete()
	{
		\base\FileUtil::UnlinkDir(ROOT.'runtime'.DS.'log');

		return $this->success('更新成功');
	}
}
?>