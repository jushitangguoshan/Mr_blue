<?php
namespace app\service;

use app\admin\controller\System;
use think\Db;
/**
 * 导航服务层
 */
class NoticeService{
	/**
     * 消息通知
     * @param    [array]          $params [输入参数]
     */
    public static function NoticeList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        // 获取消息列表
        $data = Db::name('Notice')->alias('n')
            ->join('Admin a','n.admin_id=a.id')
            ->where($where)->order('add_time','desc')
            ->field('n.id,n.type,n.title,n.content,n.admin_id,n.click,n.add_time,a.username')
            ->limit($m, $n)->select();

        if(!empty($data))
        {
            $common_is_enable_tips = lang('common_is_enable_tips');
            foreach($data as &$v)
            {
                // 时间
                if(isset($v['add_time']))
                {
                    $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                }
            }
        }
        return $data;
    }

    /**
     * 消息总数
     * @param    [array]          $where [条件]
     */
    public static function NoticeTotal($where)
    {
        return (int) Db::name('notice')->alias('a')->where($where)->count();
    }
    
    /**
     * 列表条件
     * @param   [array]          $params [输入参数]
     */
    public static function NoticeListWhere($params = [])
    {   
        $where = [];

        if(!empty($params['keywords']))
        {
            $where[] = ['title', 'like', '%'.$params['keywords'].'%'];
        }
        if(!empty($params['time_start']) && !empty($params['time_end'])){
            $start_time = strtotime($params['time_start']);
            $end_time = strtotime($params['time_end']);
            $where[] = ['a.add_time','between',[$start_time,$end_time]];
        }

        return $where;
    }

    /**
     * 保存
     * @param   [array]          $params [输入参数]
     */
    public static function NoticeSave($params = [])
    {
        // 请求类型
        $p = [
            [
                'checked_type'      => 'length',
                'key_name'          => 'title',
                'checked_data'      => '2,30',
                'error_msg'         => '通知标题格式 2~30 个字符',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'content',
                'error_msg'         => '请选择通知内容',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'admin_id',
                'error_msg'         => '创建者id未获取',
            ],
           
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 数据
        $data = [
            'title'          => $params['title'],
            'admin_id'        => empty($params['admin_id'])? '' : $params['admin_id'],
            'content'       => empty($params['content']) ? '' : $params['content'],
        ];
        if(empty($params['id']))
        {   
            $data['add_time'] = time();
            $notice_id = Db::name('notice')->insertGetId($data);
            
            $admin_ids = empty($params['admin_ids'])?'':explode(',',$params['admin_ids']);
            $user_ids = empty($params['user_ids'])?'':explode(',',$params['user_ids']);
            $admin_notice = '';
            $user_notice = '';
            
            if($admin_ids){
                $log_data = array();
                foreach ($admin_ids as $k1 => $val1) {
                    $log_data[$k1]['admin_id'] = $val1;
                    $log_data[$k1]['user_id'] = 0;
                    $log_data[$k1]['add_time'] = time();
                    $log_data[$k1]['notice_id'] = $notice_id;
                }
                $admin_notice = Db::name('notice_log')->insertAll($log_data);
            }
            
            if($user_ids){
                $log_data = array();
                foreach ($user_ids as $k => $val) {
                    $log_data[$k]['user_id'] = $val;
                    $log_data[$k]['admin_id'] = 0;
                    $log_data[$k]['add_time'] = time();
                    $log_data[$k]['notice_id'] = $notice_id;
                }

                $user_notice = Db::name('notice_log')->insertAll($log_data);
            }


            if($notice_id > 0)
            {   
                if($admin_notice || $user_notice){
                    $logs = [
                        'admin_id'=>$params['admin']['id'],
                        'title'=>'增加',
                        'detail'=>$params['admin']['username'].'增加了消息通知',
                        'add_time'=>time()
                    ];
                    System::AdminLogSave($logs);
                    return DataReturn('添加成功', 0);
                }else{
                    return DataReturn('添加失败', -100);
                }
                
            }
            return DataReturn('添加失败', -100);
        } else {
            // $data['upd_time'] = time();      //更新时间
            if(Db::name('notice')->where(['id'=>intval($params['id'])])->update($data))
            {
                $logs = [
                    'admin_id'=>$params['admin']['id'],
                    'title'=>'修改',
                    'detail'=>$params['admin']['username'].'修改了消息通知'.$params['id'],
                    'add_time'=>time()
                ];
                System::AdminLogSave($logs);
                return DataReturn('编辑成功', 0);
            }
            return DataReturn('编辑失败', -100); 
        }
    }

     /**
     * 删除
     * @param   [array]          $params [输入参数]
     */
    public static function NoticeDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '操作id有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 删除操作
        if(Db::name('notice')->where(['id'=>$params['id']])->delete())
        {
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$params['admin']['username'].'删除了消息通知'.$params['id'],
                'add_time'=>time()
            ];
            System::AdminLogSave($logs);
            return DataReturn('删除成功');
        }

        return DataReturn('删除失败或资源不存在', -100);
    }

    /**
     * 未读通知消息
     * @param   [array]          $params [输入参数]
     */
    public static function NoticeRead($params = [])
    {
        $admin = session('admin');
        $no_read = Db::name('notice_log')->alias('a')->leftjoin('cms_notice b','a.notice_id = b.id')->where(['a.admin_id'=>$admin['id'],'a.status'=>0])->field('b.title, b.content,a.admin_id,b.id')->order('b.add_time','desc')->select();
        $data = Db::name('notice')->where(['type'=>'system'])->field('id,title, content')->order('add_time','desc')->find();
        return DataReturn('处理成功', 0, $data);
    }


}