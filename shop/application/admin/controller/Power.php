<?php

namespace app\admin\controller;

use app\service\AdminPowerService;

/**
 * 权限管理
 */
class Power extends Common
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
     * [Index 权限组列表]
     */
	public function Index()
	{
		$data_params = [
			'field'		=> 'id,pid,name,control,action,sort,is_show,icon',
			'order_by'	=> 'sort asc',
			'where'		=> ['pid'=>0],
		];
		$data = AdminPowerService::PowerList($data_params);

		$this->assign('data', $data);
		$this->assign('common_is_show_list', lang('common_is_show_list'));
		return $this->fetch();
	}

	/**
	 * [PowerSave 权限添加/编辑]
	 */
	public function PowerSave()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return AdminPowerService::PowerSave($params);
	}

	/**
	 * [PowerDelete 权限删除]
	 */
	public function PowerDelete()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return AdminPowerService::PowerDelete($params);
	}

	/**
	 * [Role 角色组列表]
	 */
	public function Role()
	{
		$data_params = [
			'field'	=> 'id,name,is_enable,add_time',
		];
		$data = AdminPowerService::RoleList($data_params);

		$this->assign('data', $data);
		return $this->fetch();
	}

	/**
	 * [RoleSaveInfo 角色组添加/编辑页面]
	 */
	public function RoleSaveInfo()
	{
		// 参数
		$params = input();

		// 角色组
		if(!empty($params['id']))
		{
			$data_params = [
				'where'	=> ['id'=>intval($params['id'])],
			];
			$data = AdminPowerService::RoleList($data_params);
			if(!empty($data[0]['id']))
			{
				$this->assign('data', $data[0]);

				// 权限关联数据
				$params['role_id'] =  $data[0]['id'];
			}
		}

		// 菜单列表
		$power = AdminPowerService::RolePowerEditData($params);

		$this->assign('common_is_enable_list', lang('common_is_enable_list'));
		$this->assign('power', $power);
		return $this->fetch();
	}

	/**
	 * [RoleSave 角色组添加/编辑]
	 */
	public function RoleSave()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 开始操作
		return AdminPowerService::RoleSave(input('post.'));
	}

	/**
	 * [RoleDelete 角色删除]
	 */
	public function RoleDelete()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error('非法访问');
		}

		// 开始操作
		return AdminPowerService::RoleDelete(input('post.'));
	}

	/**
	 * [RoleStatusUpdate 角色状态更新]
	 */
	public function RoleStatusUpdate()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return AdminPowerService::RoleStatusUpdate($params);
	}
}
?>