<?php

namespace app\index\controller;

use app\service\UserService;

/**
 * 个人资料
 */
class Personal extends Common
{
	/**
     * 构造方法
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->IsLogin();
    }

	/**
	 * [Index 首页]
	 */
	public function Index()
	{
		$this->assign('personal_show_list', lang('personal_show_list'));
		return $this->fetch();
	}

	/**
	 * [SaveInfo 编辑页面]
	 */
	public function SaveInfo()
	{
		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// 数据
		$this->assign('data', $this->user);

		return $this->fetch();
	}

	/**
	 * [Save 数据保存]
	 */
	public function Save()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
        $params['user'] = $this->user;
        return UserService::PersonalSave($params);
	}
}
?>