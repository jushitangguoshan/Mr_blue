<?php
namespace app\admin\controller;

use think\Db;
use app\service\NoticeService;
use think\Request;
class Notice extends Common{
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

	public function Notice_list(){
		// 参数
        $params = input();

        // 分页
        $number = MyC('admin_page_number', 10, true);

        // 条件
        $where = NoticeService::NoticeListWhere($params);

        // 获取总数
        $total = NoticeService::NoticeTotal($where);

        // 分页
        $page_params = array(
                'number'    =>  $number,
                'total'     =>  $total,
                'where'     =>  $params,
                'page'      =>  isset($params['page']) ? intval($params['page']) : 1,
                'url'       =>  MyUrl('admin/notice/Notice_list'),
            );
        $page = new \base\Page($page_params);
        $this->assign('page_html', $page->GetPageHtml());

        // 获取列表
        $data_params = array(
            'm'     => $page->GetPageStarNumber(),
            'n'     => $number,
            'where' => $where,
            'field' => '*',
        );
        $data = NoticeService::NoticeList($data_params);
        $this->assign('data', $data);
        // echo '<pre>';
        // print_r($data);
        // 参数
        $this->assign('params', $params);
        return $this->fetch();
        
	}

	/**
     * [SaveInfo 添加/编辑页面]
     */
    public function SaveInfo()
    {
        // 参数
        $params = input();

        // 数据
        if(!empty($params['id']))
        {
            // 获取列表
            $data_params = array(
                'm'     => 0,
                'n'     => 1,
                'where' => ['a.id'=>intval($params['id'])],
                'field' => '*',
            );
            $data = NoticeService::NoticeList($data_params);

            $this->assign('data', empty($data['data'][0]) ? [] : $data['data'][0]);
        }else{
        	$admin_user = DB::name('admin')->field('id,username')->select();
        	$customer_user = DB::name('user')->where(array('is_delete_time'=>0))->field('id,username,gender as sex,email,mobile,avatar')->select();
        	// echo '<pre>';
        	// print_r($admin_user);
        	// print_r($customer_user);
        	$this->assign('admin_user',$admin_user);
        	$this->assign('customer_user',$customer_user);
        }

		// 参数
        $this->assign('params', $params);
        return $this->fetch();
    }

    /**
	 * [Save 通知保存]
	 */
	public function Save()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['admin'] = $this->admin;
        return NoticeService::NoticeSave($params);
	}
	

	public function Delete()
	{
		// 是否ajax请求
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始处理
        $params = input();
        $params['user_type'] = 'admin';
        $params['admin'] = $this->admin;
        return NoticeService::NoticeDelete($params);
	}
	

	/**
     * [read_notice 查看通知页面]
     */
    public function ReadNotice(Request $request){
    	$notice_id = $request->id?$request->id:exit('非法访问');
    	$admin_user = session('admin');
    	$notice_list = DB::name('notice')->where(['id'=>$notice_id])->find();
        if($notice_list){
            $notice_list['add_time'] = date('Y-m-d H.i.s',$notice_list['add_time']);
            $save_data = array('status'=>1,'read_time'=>time());
            $r = DB::name('notice_log')->where(['to_admin_id'=>$admin_user['id'],'notice_id'=>$notice_id])->update($save_data);
            $this->assign('notice_list', $notice_list);
            print_r($notice_list);exit;
            return $this->fetch();
        }else{
            $this->error('该通知不存在');
        }
    	
    }

    //获取组
    public function GetList(){
        $who = input("who");
        if($who==2){
           $data = Db::name('Role')->field('id,name')->where('is_enable',1)->select();
        }else{
            $data = [['id'=>1,'name'=>'普通会员'],['id'=>2,'name'=>'VIP会员'],['id'=>3,'name'=>'超级会员']];
        }
        return $data;
    }

    //获取单个
    public function GetSingle(){
        $who = input("who");
        $group = input("group");
        if($who == 2){
            $data = Db::name('Admin')->where('role_id',$group)->select();
        }
    }
}
