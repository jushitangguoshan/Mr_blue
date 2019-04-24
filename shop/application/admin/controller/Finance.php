<?php

namespace app\admin\controller;

use app\service\FinanceService;
use app\service\PaymentService;
use think\Db;


class Finance extends Common
{
    /**
     * 构造方法
||||||| .r141
class Finance extends Common
{
    /**
     * 构造方法
=======
class Finance extends Common{

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
     * 资金管理
>>>>>>> .r155
     */
	public function Index(){
		return ('资金管理');
	}

	/**
     * 收款管理
     */
	public function Gathering(){

		// 参数
		$params = input();
		
		// 条件
		$where = FinanceService::GatheringListWhere($params);

		// 总数
		$total = FinanceService::GatheringTotal($where);

		// 分页
		$number = MyC('admin_page_number', 10, true);
		$page_params = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$params,
				'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
				'url'		=>	MyUrl('admin/finance/gathering'),
			);
		$page = new \base\Page($page_params);

		// 获取管理员列表
		$data_params = [
			'where'		=> $where,
			'm'			=> $page->GetPageStarNumber(),
			'n'			=> $number,
		];

		$data = FinanceService::GatheringList($data_params);//获取返回值

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));
		// 分页
		$this->assign('params', $params);
		$this->assign('page_html', $page->GetPageHtml());

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		
		// 数组
		$this->assign('data', $data['data']);
		return $this->fetch();
	}

	/**
     * 付款管理
     */
	public function Payment()
	{
		// 参数
		$params = input();
		
		// 条件
		$where = FinanceService::PaymentListWhere($params);

		// 总数
		$total = FinanceService::PaymentTotal($where);

		// 分页
		$number = MyC('admin_page_number', 10, true);
		$page_params = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$params,
				'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
				'url'		=>	MyUrl('admin/finance/payment'),
			);
		$page = new \base\Page($page_params);

		// 获取管理员列表
		$data_params = [
			'where'		=> $where,
			'm'			=> $page->GetPageStarNumber(),
			'n'			=> $number,
		];

		$data = FinanceService::PaymentList($data_params);//获取返回值

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));
		
		// 分页
		$this->assign('params', $params);
		$this->assign('page_html', $page->GetPageHtml());

		// 数组
		$this->assign('data', $data['data']);
		return $this->fetch();
	}

	/**
     * 报表管理
     */
    public function Statement(){
        $nowTime = time();
        $dayTime = $nowTime - 1*24*60*60; //24小时以前
        $weekTime = $nowTime - 7*24*60*60; //一周以前
        $monthTime = $nowTime - 30*24*60*60; //一月以前
        $yearTime = $nowTime - 365*24*60*60; //一年以前
        $data = [
            'day'=>FinanceService::GetTimeFinance($dayTime),
            'week'=>FinanceService::GetTimeFinance($weekTime),
            'month'=>FinanceService::GetTimeFinance($monthTime),
            'year'=>FinanceService::GetTimeFinance($yearTime)
        ];
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * 获取日收入详情
     */
    public function DayOrderDetail(){
        $params = input();
        // 分页
        $number = 10;

        $nowTime = time();
        $params['pay_time'] = $nowTime - 1*24*60*60; //24小时以前
        var_dump($params);
        // 条件
        $where = FinanceService::OrderDetailWhere($params);
        var_dump($where);
        // 获取总数
        $total = FinanceService::OrderDetailTotal($where);
        var_dump($total);
        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('admin/Finance/DayOrderDetail'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = FinanceService::GetOrderDetail($data_params);
        $this->assign('data',$data);

        $this->assign('payment_list',PaymentService::PaymentList());
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * 获取周收入详情
     */
    public function WeekOrderDetail(){
        $params = input();
        // 分页
        $number = 10;

        $nowTime = time();
        $params['pay_time'] = $nowTime - 7*24*60*60; //一周以前

        // 条件
        $where = FinanceService::OrderDetailWhere($params);

        // 获取总数
        $total = FinanceService::OrderDetailTotal($where);

        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('admin/Finance/WeekOrderDetail'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = FinanceService::GetOrderDetail($data_params);
        $this->assign('data',$data);

        $this->assign('payment_list',PaymentService::PaymentList());
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * 获取月收入详情
     */
    public function MonthOrderDetail(){
        $params = input();
        // 分页
        $number = 10;

        $nowTime = time();
        $params['pay_time'] = $nowTime - 30*24*60*60; //一月以前

        // 条件
        $where = FinanceService::OrderDetailWhere($params);

        // 获取总数
        $total = FinanceService::OrderDetailTotal($where);

        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('admin/Finance/MonthOrderDetail'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = FinanceService::GetOrderDetail($data_params);
        $this->assign('data',$data);

        $this->assign('payment_list',PaymentService::PaymentList());
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * 获取年收入详情
     */
    public function YearOrderDetail(){
        $params = input();
        // 分页
        $number = 10;

        $nowTime = time();
        $params['pay_time'] = $nowTime - 365*24*60*60; //一年以前

        // 条件
        $where = FinanceService::OrderDetailWhere($params);

        // 获取总数
        $total = FinanceService::OrderDetailTotal($where);

        // 分页
        $page_params = array(
            'number'    =>  $number,
            'total'     =>  $total,
            'where'     =>  $params,
            'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
            'url'       =>  MyUrl('admin/Finance/YearOrderDetail'),
        );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = FinanceService::GetOrderDetail($data_params);
        $this->assign('data',$data);

        $this->assign('payment_list',PaymentService::PaymentList());
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }
}