<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2019 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\service\Area;
use app\service\GoodsCommentService;
use app\service\GoodsService;
use app\service\OrderService;
use app\service\PaymentService;
use app\service\ExpressService;
use think\Db;
use think\Request;

/**
 * 订单管理
 */
class Order extends Common
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
     * 评论管理
     */
    public function Comment()
    {
        // 参数
        $params = input();

        // 条件
        $where =GoodsService::GetAdminIndexWhere($params);
        // 总数
        $total = GoodsService::GoodsTotal($where);

        // 分页
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$params,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/goods/index'),
        );
        $page = new \base\Page($page_params);

        // 获取数据列表
        $data_params = [
            'where'			=> $where,
            'm'				=> $page->GetPageStarNumber(),
            'n' 			=> $number,
            'is_category'	=> 1,
        ];
        $data = GoodsService::GoodsList($data_params);

        // 是否上下架
        $this->assign('common_is_shelves_list', lang('common_is_shelves_list'));
        $this->assign('params', $params);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data', $data);
        return $this->fetch();
    }
    /**
     * 手写删除
     */
    public function del()
    {
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        $params = input();
        return OrderService::OrderDel($params);
    }
    /**
     * 订单列表
     */
    public function Index()
    {
        // 参数
        $params = input();
        $params['admin'] = $this->admin;
        $params['user_type'] = 'admin';
        // 分页
        $number = 10;

        // 条件
        $where = OrderService::OrderListWhere($params);

        // 获取总数
        $total = OrderService::OrderTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/order/index'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = OrderService::OrderList($data_params);
        $this->assign('data_list', $data['data']);

        // 状态
        $this->assign('common_order_admin_status', lang('common_order_admin_status'));

        // 支付状态
        $this->assign('common_order_pay_status', lang('common_order_pay_status'));

        // 快递公司
        $this->assign('express_list', ExpressService::ExpressList());

        // 发起支付 - 支付方式
        $pay_where = [
            'where' => ['is_enable'=>1, 'is_open_user'=>1, 'payment'=>config('shopxo.under_line_list')],
        ];
        $this->assign('buy_payment_list', PaymentService::BuyPaymentList($pay_where));

        // 支付方式
        $this->assign('payment_list', PaymentService::PaymentList());

        // 评价状态
        $this->assign('common_comments_status_list', lang('common_comments_status_list'));

        // Excel地址
        $this->assign('excel_url', MyUrl('admin/order/excelexport', input()));

        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * [ExcelExport excel文件导出]
     */
    public function ExcelExport()
    {
        // 参数
        $params = input();
        $params['admin'] = $this->admin;
        $params['user_type'] = 'admin';

        // 条件
        $where = OrderService::OrderListWhere($params);

        // 获取列表
        $data_params = array(
            'where'             => $where,
            'm'                 => 0,
            'n'                 => 100000,
            'is_excel_export'   => 1,
        );
        $data = OrderService::OrderList($data_params);

        // Excel驱动导出数据
        $excel = new \base\Excel(array('filename'=>'order', 'title'=>lang('excel_order_title_list'), 'data'=>$data['data'], 'msg'=>'没有相关数据'));
        return $excel->Export();
    }
    /**
     * 订单编辑
     */
    public function update(Request $request)
    {
        /**
         * 接收修改消息
         */
        if ($request->isPost()){
            return OrderService::SetOrder($request->post());
        }
        $orderStatus = ['待确认','已确认','已支付','已发货','已完成','已取消','已关闭','退货中','换货中'];
        $oid = $request->param('oid');
        if ($oid){
            $order = OrderService::GetOneOrder($oid);
            $payment = PaymentService::GetPaymentName();
            $this->assign(['order'=>$order,'payment'=>$payment,'orderStatus'=>$orderStatus]);
            return  $this->fetch();
        }
        return $this->error("非法访问");
  }


    /**
     * [Delete 订单删除]
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }
        // 删除操作
        $params = input();
        $params['user_id'] = $params['id'];
        $params['creator'] = $this->admin['id'];
        $params['creator_name'] = $this->admin['username'];
        $params['user_type'] = 'admin';

        return OrderService::OrderDelete($params);
    }

    /**
     * [Cancel 订单取消]
     */
    public function Cancel()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 取消操作
        $params = input();
        $params['user_id'] = $params['value'];
        $params['creator'] = $this->admin['id'];
        $params['creator_name'] = $this->admin['username'];
        return OrderService::OrderCancel($params);
    }

    /**
     * [Delivery 订单发货]
     */
    public function Delivery()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 发货操作
        $params = input();
        $params['creator'] = $this->admin['id'];
        $params['creator_name'] = $this->admin['username'];
        return OrderService::OrderDelivery($params);
    }

    /**
     * [Collect 订单收货]
     */
    public function Collect()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 收货操作
        $params = input();
        $params['user_id'] = $params['value'];
        $params['creator'] = $this->admin['id'];
        $params['creator_name'] = $this->admin['username'];
        return OrderService::OrderCollect($params);
    }

    /**
     * [Confirm 订单确认]
     */
    public function Confirm()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 订单确认
        $params = input();
        $params['user_id'] = $params['value'];
        $params['creator'] = $this->admin['id'];
        $params['creator_name'] = $this->admin['username'];
        return OrderService::OrderConfirm($params);
    }

    /**
     * 订单支付
     * @desc    description
     */
    public function Pay()
    {
        $params = input();
        $params['user'] = $this->admin;
        $params['user']['user_name_view'] = '管理员'.'-'.$this->admin['username'];
        return OrderService::AdminPay($params);
    }

    /**
     * 售后服务
     * @desc    description
     */
    public function Service()
    {
        $params = input();
        $params['user'] = $this->admin;
        $params['user']['user_name_view'] = '管理员'.'-'.$this->admin['username'];
        $params['service']=1;
         // 分页
        $number = 10;

        // 条件
       
        $where = OrderService::OrderListWhere($params);
        // $where[0]['service'] = 1 ; 
        // 获取总数
        $total = OrderService::OrderTotal($where);
        // print_r($total);die;
        

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/order/service'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = OrderService::OrderList($data_params);
        // var_dump($data);
        $this->assign('data_list', $data['data']);



        // 状态
        $this->assign('common_order_admin_status', lang('common_order_admin_status'));

        // 支付状态
        $this->assign('common_order_pay_status', lang('common_order_pay_status'));

        // 快递公司
        $this->assign('express_list', ExpressService::ExpressList());

        // 发起支付 - 支付方式
        $pay_where = [
            'where' => ['is_enable'=>1, 'is_open_user'=>1, 'payment'=>config('shopxo.under_line_list')],
        ];
        $this->assign('buy_payment_list', PaymentService::BuyPaymentList($pay_where));

        // 支付方式
        $this->assign('payment_list', PaymentService::PaymentList());

        // 评价状态
        $this->assign('common_comments_status_list', lang('common_comments_status_list'));

        // Excel地址
        $this->assign('excel_url', MyUrl('admin/order/excelexport', input()));

        // 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
     * 修改评论排序
     */
    public function UpdCommentSort(){
        $params = input();
        $data = GoodsCommentService::UpdCommentSort($params);
        echo "<script>history.back();</script>";
    }

}
?>