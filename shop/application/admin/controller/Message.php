<?php

namespace app\admin\controller;

use app\service\MessageService;

/**
 * 消息管理
 */
class Message extends Common
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
     * [Index 消息列表]
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
        $where = MessageService::AdminMessageListWhere($params);

        // 获取总数
        $total = MessageService::AdminMessageTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/message/index'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'         => $page->GetPageStarNumber(),
            'n'         => $number,
            'where'     => $where,
        );
        $data = MessageService::AdminMessageList($data_params);
        $this->assign('data_list', $data['data']);

		// 性别
		$this->assign('common_gender_list', lang('common_gender_list'));

		// 消息类型
		$this->assign('common_message_type_list', lang('common_message_type_list'));

		// 是否已读
		$this->assign('common_is_read_list', lang('common_is_read_list'));

		// 参数
        $this->assign('params', $params);
        return $this->fetch();
	}

	/**
	 * [Delete 消息删除]
	 */
	public function Delete()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['admin'] = $this->admin;
        return MessageService::MessageDelete($params);
	}
}
?>