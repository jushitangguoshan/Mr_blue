<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/3 0003
 * Time: 10:35
 */

namespace app\admin\controller;
use think\Db;

class Supply extends Common
{
    public function index()
    {
        $params = input();
        $count = count($params);
        $post = [];
        if($count > 1){
            foreach($params as $key => $val){
                if($val != ""){
                    if($val == "add_time" ){
                        $post[$key] = [$key,">",strtotime($val)];
                    }else if($val == "upd_time"){
                        $post['add_time'] = [$key,"<",strtotime($val)];
                    }else{
                        $post[$key] = $val;
                    }
                }
            }
        }
        $total = Db::name("business")->where($post)->count();
        $where = isset($post) ? $post : $params;
        $number = MyC('admin_page_number', 10, true);
        $page_params = array(
            'number'	=>	$number,
            'total'		=>	$total,
            'where'		=>	$where,
            'page'		=>	isset($params['page']) ? intval($params['page']) : 1,
            'url'		=>	MyUrl('admin/supply/index'),
        );
        $page = new \base\Page($page_params);
        // 获取管理员列表
        $data_params = [
        'where'		=> $where,
			'm'			=> $page->GetPageStarNumber(),
			'n'			=> $number,
		];
        $data = Db::name("business")->where($post)->limit($data_params['m'],$data_params['n'])->select();
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign("data",$data);
        $this->assign("params",$params);
        return $this->fetch();
    }

    /**
     * 增加、编辑供应商 页面
     */
    public function add()
    {
        $params = input();
        if(!empty($params)){
            if(!empty($params['page'])){
                unset($params['page']);
            }
            $data = Db::name("business")->where($params)->select();
            $this->assign("data",$data[0]);
        }
        return $this->fetch();
    }

    /**
     * 增加、编辑供应商
     */
    public function update()
    {
        $params = input();
        $time = time();
        if (!empty($params)) {
            if(empty($params['business_name'])){
                $this->success("供应商名称不能为空");exit;
            }
            if(empty($params['address'])){
                $this->success("供应商地址不能为空");exit;
            }
            if ($params['phone'] == "" && $params['landline'] == "" && $params['email'] == "") {
                $this->success("联系方式不能为空");exit;
            }

            if (!empty($params['id'])) {
                $name = Db::name("business")->where('id',$params['id'])->field("business_name")->select();
                $name = $name[0]['business_name'];
                $params['upd_time'] = $time;
                if (!Db::name("business")->where('id',$params['id'])->update($params)) {
                    $this->success("修改失败",Myurl("admin/supply/index"));exit;
                }
                $params['admin'] = $this->admin;
                $logs = [
                    'admin_id'=>$this->admin['id'],
                    'title'=>'修改',
                    'detail'=>$this->admin['username'].'修改了供应商： '. $name,
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                $this->error("修改成功",Myurl("admin/supply/index"));
            } else {
                $params['add_time'] = $time;
                if (!Db::name("business")->insert($params)) {
                    $this->success("增加失败",Myurl("admin/supply/index"));
                    exit;
                }
                $params['admin'] = $this->admin;
                $logs = [
                    'admin_id'=>$this->admin['id'],
                    'title'=>'增加',
                    'detail'=>$this->admin['username'].'增加了供应商： '. $params['business_name'],
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                $this->error("增加成功",Myurl("admin/supply/index"));
            }
        }
    }

    /**
     * 删除供应商
     */
    public function delete()
    {
        $params = input();
        if(!empty($params)){
            $name = Db::name("business")->where($params)->field("business_name")->select();
            if(!Db::name("business")->where($params)->delete()){
                $this->success("删除失败",Myurl("admin/supply/index"));exit;
            }
            $params['admin'] = $this->admin;
            $name = $name[0]['business_name'] == "" ? $params['id'] : $name[0]['business_name'];
            $logs = [
                'admin_id'=>$this->admin['id'],
                'title'=>'删除',
                'detail'=>$this->admin['username'].'删除了供应商： '. $name,
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            //return DataReturn("删除成功");
            $this->error("删除成功",Myurl("admin/supply/index"));
        }
    }
}