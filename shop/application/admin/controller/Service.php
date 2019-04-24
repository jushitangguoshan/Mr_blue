<?php

namespace app\admin\controller;

use app\service\BrandService;
use app\service\ServeService;
use think\Db;

/**
 * 售后处理
 */
class Service extends Common
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
     * [Index 售后订单列表]
     */
	public function Index()
	{
        $data = Db::name("after_service")->select();
        foreach($data as $key => $val){

        }
        $this->assign("data",$data);
        return $this->fetch();
	}

    /**
     * [update 修改订单列表]
     */
    public function update()
    {

    }


    /**
     * [delete 删除订单列表]
     */
    public function delete()
    {
        $params = input();
        if(!empty($params)){
            $data = Db::name("after_service")->field("goods_status")->where($params)->select();
            if($data[0]['goods_status'] == 1){
                $this->success('删除失败');
            }else{
                Db::name("after_service")->where($params)->delete();
                $logs = [
                    'admin_id'=>$params['admin']['id'],
                    'title'=>'删除',
                    'detail'=>$params['admin']['username'].'删除了'.$params['name']."信息",
                    'add_time'=>time()
                ];
                $log = System::AdminLogSave($logs);
                $this->error('删除成功');
            }
        }
    }

    /**
     * [add 增加订单列表]
     */
    public function add()
    {
        $params = input();
        if(!empty($params)){
            if(!Db::name("after_service")->insert($params)){
                return DataReturn("增加失败",304);
            }
            return DataReturn("增加成功",200);
        }
    }
}
?>