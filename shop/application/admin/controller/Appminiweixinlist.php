<?php

namespace app\admin\controller;

use app\service\AppMiniService;

/**
 * 微信小程序管理
 */
class AppMiniWeixinList extends Common
{
	private $application_name;
	private $old_path;
	private $new_path;

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

		// 参数
		$this->params = input();
		$this->params['application_name'] = 'weixin';
	}

	/**
     * [Index 列表]
     */
	public function Index()
	{
		$this->assign('data', AppMiniService::DataList($this->params));
		return $this->fetch();
	}

	/**
	 * [Created 生成]
	 */
	public function Created()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 配置内容
        $app_mini_title = MyC('common_app_mini_weixin_title');
        $app_mini_describe = MyC('common_app_mini_weixin_describe');
        if(empty($app_mini_title) || empty($app_mini_describe))
        {
            return DataReturn('配置信息不能为空', -1);
        }

		// 开始操作
		$this->params['app_mini_title'] = $app_mini_title;
		$this->params['app_mini_describe'] = $app_mini_describe;
		return AppMiniService::Created($this->params);
	}

	/**
	 * [Delete 删除包]
	 */
	public function Delete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 开始操作
		return AppMiniService::Delete($this->params);
	}
}
?>