<?php

namespace app\admin\controller;

use app\service\PaymentService;

/**
 * 支付方式管理
 */
class Payment extends Common
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
     * [Index 支付方式列表]
     */
	public function Index()
	{
        // 插件列表
        $this->assign('data_list', PaymentService::PlugPaymentList());

        // 不删除的支付方式
        $this->assign('cannot_deleted_list', PaymentService::$cannot_deleted_list);

        // 适用平台
        $this->assign('common_platform_type', lang('common_platform_type'));

        return $this->fetch();
	}

    /**
     * [SaveInfo 添加/编辑页面]
     */
    public function SaveInfo()
    {
        // 参数
        $params = input();

        // 商品信息
        if(!empty($params['id']))
        {
            $data_params = [
                'where'             => ['id'=>$params['id']],
                'm'                 => 0,
                'n'                 => 1,
            ];
            $data = PaymentService::PaymentList($data_params);
            if(empty($data[0]))
            {
                return $this->error('没有相关支付方式', MyUrl('admin/payment/index'));
            }
            $this->assign('data', $data[0]);
        }

        // 适用平台
        $this->assign('common_platform_type', lang('common_platform_type'));

        // 参数
        $this->assign('params', $params);

        return $this->fetch();
    }

	/**
	 * [Save 支付方式保存]
	 */
	public function Save()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PaymentService::PaymentUpdate(input());
	}

	/**
     * [StatusUpdate 状态更新]
     */
    public function StatusUpdate()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PaymentService::PaymentStatusUpdate(input());
    }

    /**
     * 安装
     * @desc    description
     */
    public function Install()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PaymentService::Install(input());
    }

    /**
     * 卸载
     * @desc    description
     */
    public function Uninstall()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PaymentService::Uninstall(input());
    }

    /**
     * 删除插件
     * @desc    description
     */
    public function Delete()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PaymentService::Delete(input());
    }

    /**
     * 上传插件
     * @desc    description
     */
    public function Upload()
    {
        // 是否ajax请求
        if(!IS_AJAX)
        {
            $this->error('非法访问');
        }

        // 开始操作
        return PaymentService::Upload(input());
    }
}
?>