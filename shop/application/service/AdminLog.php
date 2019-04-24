<?php
/**
 * Created by Admin log.
 * User: blue
 * Date: 2019/3/20
 * Time: 14:12
 */


namespace app\service;

use think\Db;

class AdminLog
{
    /**
     * 管理员操作日志列表
     */
    public static function AdminLogList($params = []){

        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'id desc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        // 获取管理员日志列表
        $data = Db::name('AdminLog')->where($where)->field($field)->order($order_by)->limit($m, $n)->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['username'] = Db::name('Admin')->where(['id'=>$v['admin_id']])->value('username');
                $v['role_name'] = Db::name('Role')->where(['id'=>$v['role_id']])->value('name');
            }
        }
        return $data;
    }

    /**
     * 获取操作日志列表条件
     */
    public static function AdminLogWhere($params = []){
        $where = [];
        if(!empty($params['username']))
        {
            $where[] = ['username', 'like', '%'.$params['username'].'%'];
        }
        if(isset($params['role_id']) && $params['role_id'] > -1)
        {
            $where[] = ['role_id', '=', intval($params['role_id'])];
        }
        if(isset($params['title']) && $params['title'] != -1)
        {
            $where[] = ['title', '=', $params['title']];
        }
        // 时间
        if(!empty($params['time_start']))
        {
            $where[] = ['add_time', '>', strtotime($params['time_start'])];
        }
        if(!empty($params['time_end']))
        {
            $where[] = ['add_time', '<', strtotime($params['time_end'])];
        }
        return $where;
    }



    /**
     * 日志总数
     * @param $where
     * @return int
     */
    public static function AdminLogTotal($where)
    {
        return (int) Db::name('AdminLog')->where($where)->count();
    }

    /**
     * 角色列表
     * @param    [array]          $params [输入参数]
     */
    public static function RoleList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        return Db::name('Role')->field($field)->where($where)->select();
    }


    /**
     * 操作写入日志
     */
    public static function AdminLogWrite($params = []){
        $params['username'] = Db::name('Admin')->where(['id'=>$params['admin_id']])->value('username');
        $params['role_id'] = Db::name('Admin')->where(['id'=>$params['admin_id']])->value('role_id');
        // 添加
        if(Db::name('AdminLog')->insert($params) > 0)
        {
            return DataReturn('新增成功', 0);
        }
        return DataReturn('新增失败', -100);
    }

}
