<?php

namespace app\admin\controller;

use app\service\PayLogService;

/**
 * 支付日志管理
 */
class PayLog extends Common
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
     * [Index 支付日志列表]
     */
	public function Index()
	{
		// 参数
        $params = input();
        $params['user'] = $this->admin;
        $params['user_type'] = 'admin';

        // 分页
        $number = MyC('admin_page_number', 10, true);

        // 条件
        $where = PayLogService::AdminPayLogListWhere($params);

        // 获取总数
        $total = PayLogService::AdminPayLogTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/paylog/index'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = PayLogService::AdminPayLogList($data_params);
        $this->assign('data_list', $data['data']);

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// 业务类型
		$this->assign('common_business_type_list', lang('common_business_type_list'));

		// 支付日志类型
		$pay_type_list = PayLogService::PayLogTypeList($params);
		$this->assign('common_pay_type_list', $pay_type_list['data']);

		// 参数
        $this->assign('params', $params);
        return $this->fetch();
	}
}
?>