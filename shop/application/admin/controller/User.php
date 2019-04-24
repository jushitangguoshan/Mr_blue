<?php

namespace app\admin\controller;

use app\service\IntegralService;
use app\service\UserService;
use think\Db;

/**
 * 用户管理
 */
class User extends Common
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
     * [Index 用户列表]
     */
	public function Index()
	{
		
		// 参数
		$params = input();

		// 条件
		$where = UserService::UserListWhere($params);
		// 总数
		$total = UserService::UserTotal($where);

		// 分页
		$number = MyC('admin_page_number', 10, true);
		$page_params = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$params,
				'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
				'url'		=>	MyUrl('admin/user/index'),
			);
		$page = new \base\Page($page_params);

		// 获取管理员列表
		$data_params = [
			'where'		=> $where,
			'm'			=> $page->GetPageStarNumber(),
			'n'			=> $number,
		];
		$data = UserService::UserList($data_params);

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// Excel地址
		$this->assign('excel_url', MyUrl('admin/user/excelexport', $params));

		$this->assign('params', $params);
		$this->assign('page_html', $page->GetPageHtml());
		$this->assign('data', $data['data']);
		return $this->fetch();

	}

	/**
	 * [ExcelExport excel文件导出]
	 */
	public function ExcelExport()
	{
		// 条件
		$where = UserService::UserListWhere(input('post.'));

		$data_params = [
			'where'		=> $where,
			'm'			=> 0,
			'n'			=> 100000,
		];
		$data = UserService::UserList($data_params);

		// Excel驱动导出数据
		$excel = new \base\Excel(array('filename'=>'user', 'title'=>lang('excel_user_title_list'), 'data'=>$data['data'], 'msg'=>'没有相关数据'));
		return $excel->Export();
	}

	/**
	 * [SaveInfo 用户添加/编辑页面]
	 */
	public function SaveInfo()
	{
		// 参数
		$params = input();

		// 用户编辑
		if(!empty($params['id']))
		{
			$data_params = [
				'where'		=> ['id'=>$params['id']],
				'm'			=> 0,
				'n'			=> 1,
			];
			$data = UserService::UserList($data_params);
			if(empty($data['data'][0]))
			{
				return $this->error('用户信息不存在', MyUrl('admin/user/index'));
			}
			$data['data'][0]['birthday_text'] = empty($data['data'][0]['birthday']) ? '' : date('Y-m-d', $data['data'][0]['birthday']);
			$this->assign('data', $data['data'][0]);
		}

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// 参数
		$this->assign('params', $params);

		return $this->fetch();
	}


	/**
	 * [Save 用户添加/编辑]
	 */
	public function Save()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}

		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return UserService::UserSave($params);
	}

	/**
	 * [Delete 用户删除]
	 */
	public function Delete()
	{
		// 是否ajax
		if(!IS_AJAX)
		{
			return $this->error('非法访问');
		}
		// 开始操作
		$params = input('post.');
		$params['admin'] = $this->admin;
		return UserService::UserDelete($params);
	}

	/**
	 * [rank 客户等级]
	 */
	public function rank()
	{
		$params = input();


		// 条件
		$where = UserService::UserListWhere($params);

		// 总数
		$total = UserService::UserTotal($where);

		// 分页
		$number = MyC('admin_page_number', 10, true);
		$page_params = array(
			'number'	=>	$number,
			'total'		=>	$total,
			'where'		=>	$params,
			'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
			'url'		=>	MyUrl('admin/user/index'),
		);
		$page = new \base\Page($page_params);

		// 获取管理员列表
		$data_params = [
			'where'		=> $where,
			'm'			=> $page->GetPageStarNumber(),
			'n'			=> $number,
		];
		$data = UserService::UserList($data_params);

		$arr = $data['data'];
		$array = Db::name("user_grade")->where(["is_enable"=>0])->select();
		foreach($arr as $key => $val){
			if($val['integral'] < 1000){
				$integral = 1;
			}else if($val['integral'] >= 1000 && $val['integral']<10000){
				$integral = 2;
			}else{
				$integral = 3;
			}
			$grade = intval($val['grade']);
			$maxintegral = $grade >= $integral ? $grade : $integral;
			$data['data'][$key]['grade'] = $array[$maxintegral-1]['grade'];
		}
		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// Excel地址
		$this->assign('excel_url', MyUrl('admin/user/excelexport', $params));

		$this->assign('params', $params);
		$this->assign('page_html', $page->GetPageHtml());
		$this->assign('data', $data['data']);
		return $this->fetch();
	}

	/*
	 * [编辑会员等级]
	 */
	public function UpdateRank()
	{
		// 参数
		$params = input();
		// 用户编辑
		if(!empty($params['id']))
		{
			$data_params = [
				'where'		=> ['id'=>$params['id']],
				'm'			=> 0,
				'n'			=> 1,
			];
			$data = UserService::UserList($data_params);
			if(empty($data['data'][0]))
			{
				return $this->error('用户信息不存在', MyUrl('admin/user/index'));
			}
			$data['data'][0]['birthday_text'] = empty($data['data'][0]['birthday']) ? '' : date('Y-m-d', $data['data'][0]['birthday']);
			$this->assign('data', $data['data'][0]);
		}

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// 参数
		$this->assign('params', $params);
		$grade = Db::name("user_grade")->select();
		$this->assign('grade', $grade);

		return $this->fetch();
	}

	/**
	 * [integral 客户积分]
	 */
	public function integral()
	{
		// 参数
		$params = input();

		// 条件
		$where = UserService::UserListWhere($params);

		// 总数
		$total = UserService::UserTotal($where);

		// 分页
		$number = MyC('admin_page_number', 10, true);
		$page_params = array(
			'number'	=>	$number,
			'total'		=>	$total,
			'where'		=>	$params,
			'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
			'url'		=>	MyUrl('admin/user/index'),
		);
		$page = new \base\Page($page_params);

		// 获取管理员列表
		$data_params = [
			'where'		=> $where,
			'm'			=> $page->GetPageStarNumber(),
			'n'			=> $number,
		];
		$data = UserService::UserList($data_params);

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// Excel地址
		$this->assign('excel_url', MyUrl('admin/user/excelexport', $params));

		$this->assign('params', $params);
		$this->assign('page_html', $page->GetPageHtml());
		$this->assign('data', $data['data']);
		return $this->fetch();
	}

	/**
	 * [编辑会员积分]
	 */
	public function UpdateIntegral()
	{
		// 参数
		$params = input();

		// 用户编辑
		if(!empty($params['id']))
		{
			$data_params = [
				'where'		=> ['id'=>$params['id']],
				'm'			=> 0,
				'n'			=> 1,
			];
			$data = UserService::UserList($data_params);
			if(empty($data['data'][0]))
			{
				return $this->error('用户信息不存在', MyUrl('admin/user/index'));
			}
			$data['data'][0]['birthday_text'] = empty($data['data'][0]['birthday']) ? '' : date('Y-m-d', $data['data'][0]['birthday']);
			$this->assign('data', $data['data'][0]);
		}

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// 参数
		$this->assign('params', $params);

		return $this->fetch();
	}
}
?>