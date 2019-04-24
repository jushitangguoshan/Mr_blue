<?php

namespace app\admin\controller;

use app\service\StatisticalService;
use app\service\NoticeService;
use think\Url;

/**
 * 首页
 */
class Index extends Common
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
	}

	/**
	 * [Index 首页]
	 */
	public function Index()
	{	
		$data = NoticeService::NoticeRead();
		/*$notice_data = $notice_data['data'];
		$url = url('admin/notice/ReadNotice',"id=".$notice_data['id']);
		$notice_data['url'] = str_replace("/public","",$url);
		*/

		//未读消息
		//$this->assign('notice',$notice_data);
		//未读消息通知条数
		//$this->assign('no_read',count($notice_data));
		return $this->fetch();
	}

	/**
	 * [Init 初始化页面]
	 */
	public function Init()
	{
		// 系统信息
		$mysql_ver = db()->query('SELECT VERSION() AS `ver`');
		$data = array(
				'server_ver'	=>	php_sapi_name(),
				'php_ver'		=>	PHP_VERSION,
				'mysql_ver'		=>	isset($mysql_ver[0]['ver']) ? $mysql_ver[0]['ver'] : '',
				'os_ver'		=>	PHP_OS,
				'host'			=>	isset($_SERVER["HTTP_HOST"]) ? $_SERVER["HTTP_HOST"] : '',
				'ver'			=>	'ShopXO'.' '.APPLICATION_VERSION,
			);
		$this->assign('data', $data);

		// 用户
		$user = StatisticalService::UserYesterdayTodayTotal();
		$this->assign('user', $user['data']);

		// 订单总数
		$order_number = StatisticalService::OrderNumberYesterdayTodayTotal();
		$this->assign('order_number', $order_number['data']);

		// 订单成交总量
		$order_complete_number = StatisticalService::OrderCompleteYesterdayTodayTotal();
		$this->assign('order_complete_number', $order_complete_number['data']);

		// 订单收入总计
		$order_complete_money = StatisticalService::OrderCompleteMoneyYesterdayTodayTotal();
		$this->assign('order_complete_money', $order_complete_money['data']);

		// 近7日订单交易走势
		$order_trading_trend = StatisticalService::OrderTradingTrendSevenTodayTotal();
		$this->assign('order_trading_trend', $order_trading_trend['data']);
		
		// 近7日订单支付方式
		$order_type_number = StatisticalService::OrderPayTypeSevenTodayTotal();
		$this->assign('order_type_number', $order_type_number['data']);

		// 近7日热销商品
		$goods_hot_sale = StatisticalService::GoodsHotSaleSevenTodayTotal();
		$this->assign('goods_hot_sale', $goods_hot_sale['data']);

		return $this->fetch();
	}
}
?>