<?php

namespace app\service;

use app\admin\controller\System;
use think\Db;

/**
 * 管理员服务层
 * @datetime 2016-12-01T21:51:08+0800
 */
class AdminService
{
    /**
     * 管理员列表
     * @param    [array]          $params [输入参数]
     */
    public static function AdminList($params = [])
    {
        $where = empty($params['where']) ? [] : $params['where'];
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'id desc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;

        // 获取管理员列表
        $data = Db::name('Admin')->where($where)->field($field)->order($order_by)->limit($m, $n)->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['role_name'] = Db::name('Role')->where(['id'=>$v['role_id']])->value('name');
            }
        }
        return $data;
    }

    /**
     * 管理员列表条件
     * @param    [array]          $params [输入参数]
     */
    public static function AdminListWhere($params = [])
    {
        $where = [];
        if(!empty($params['username']))
        {
            $where[] = ['username', 'like', '%'.$params['username'].'%'];
        }
        if(isset($params['role_id']) && $params['role_id'] > -1)
        {
            $where[] = ['role_id', '=', intval($params['role_id'])];
        }

        // 等值
        if(isset($params['gender']) && $params['gender'] > -1)
        {
            $where[] = ['gender', '=', intval($params['gender'])];
        }
        return $where;
    }

    /**
     * 管理员总数
     * @param    [array]          $where [条件]
     */
    public static function AdminTotal($where)
    {
        return (int) Db::name('Admin')->where($where)->count();
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
     * 管理员保存
     * @param    [array]          $params [输入参数]
     */
    public static function AdminSave($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'admin',
                'error_msg'         => '用户信息有误',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'mobile',
                'checked_data'      => 'CheckMobile',
                'is_checked'        => 1,
                'error_msg'         => '手机号码格式错误',
            ],
            [
                'checked_type'      => 'in',
                'key_name'          => 'gender',
                'checked_data'      => [0,1,2],
                'error_msg'         => '性别值范围不正确',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        $logs = [
            'admin_id'=>$params['admin']['id'],
            'title'=>'修改',
            'detail'=>$params['admin']['username'].'修改管理员'.$params['username'].'信息',
            'add_time'=>time()
        ];
        System::AdminLogSave($logs);
        return empty($params['id']) ? self::AdminInsert($params) : self::AdminUpdate($params);
    }

    /**
     * 管理员添加
     * @param    [array]          $params [输入参数]
     */
    public static function AdminInsert($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'username',
                'error_msg'         => '用户名不能为空',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'login_pwd',
                'error_msg'         => '密码不能为空',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'username',
                'checked_data'      => 'CheckUserName',
                'error_msg'         => '用户名格式 5~18 个字符（可以是字母数字下划线）',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'login_pwd',
                'checked_data'      => 'CheckLoginPwd',
                'error_msg'         => '密码格式 6~18 个字符',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'role_id',
                'error_msg'         => '角色组有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 添加账号
        $salt = GetNumberCode(6);
        $data = [
            'username'      => $params['username'],
            'login_salt'    => $salt,
            'login_pwd'     => LoginPwdEncryption($params['login_pwd'], $salt),
            'mobile'        => isset($params['mobile']) ? $params['mobile'] : '',
            'gender'        => intval($params['gender']),
            'role_id'       => intval($params['role_id']),
            'add_time'      => time(),
        ];

        // 添加
        if(Db::name('Admin')->insert($data) > 0)
        {
            $adm2_id = Db::name('admin')->getLastInsID();
            $adm = Db::name('admin')->where(['id'=>$params['admin']['id']])->value('username');
            $adm2 = DB::name('admin')->where(['id'=>$adm2_id])->value('username');
            return DataReturn('新增成功', 0);
        }
        return DataReturn('新增失败', -100);
    }

    /**
     * 管理员更新
     * @param    [array]          $params [输入参数]
     */
    public static function AdminUpdate($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'fun',
                'key_name'          => 'login_pwd',
                'checked_data'      => 'CheckLoginPwd',
                'is_checked'        => 1,
                'error_msg'         => '密码格式 6~18 个字符',
            ],
        ];
        if($params['id'] != $params['admin']['id'])
        {
            $p[] = [
                'checked_type'      => 'empty',
                'key_name'          => 'role_id',
                'error_msg'         => '角色组有误',
            ];
        }
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 添加账号
        $data = [
            'mobile'        => isset($params['mobile']) ? $params['mobile'] : '',
            'gender'        => intval($params['gender']),
            'upd_time'      => time(),
        ];

        // 密码
        if(!empty($params['login_pwd']))
        {
            $data['login_salt'] = GetNumberCode(6);
            $data['login_pwd'] = LoginPwdEncryption($params['login_pwd'], $data['login_salt']);
        }
        // 不能修改自身所属角色组
        if($params['id'] != $params['admin']['id'])
        {
            $data['role_id'] = intval($params['role_id']);
        }

        // 更新
        if(Db::name('Admin')->where(['id'=>intval($params['id'])])->update($data))
        {
            // 自己修改密码则重新登录
            if(!empty($params['login_pwd']) && $params['id'] == $params['admin']['id'])
            {
                session_destroy();
            }
            $adm = Db::name('admin')->where(['id'=>$params['admin']['id']])->value('username');
            $adm2 = Db::name('admin')->where(['id'=>$params['id']])->value('username');

            return DataReturn('编辑成功', 0);
        }
        return DataReturn('编辑失败或数据未改变', -100);
    }

    /**
     * 管理员删除
     * @param    [array]          $params [输入参数]
     */
    public static function AdminDelete($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'id',
                'error_msg'         => '删除id有误',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }
           
        // 删除操作
        $adm2 = Db::name('admin')->where(['id'=>intval($params['id'])])->value('username');
        if(Db::name('Admin')->delete(intval($params['id'])))
        {
            $adm = Db::name('admin')->where(['id'=>$params['admin']['id']])->value('username');
            $logs = [
                'admin_id'=>$params['admin']['id'],
                'title'=>'删除',
                'detail'=>$adm.'删除了管理员'.$adm2,
                'add_time'=>time()
            ];
            $log = System::AdminLogSave($logs);
            return DataReturn('删除成功');
        }
        return DataReturn('删除失败或资源不存在', -100);
    }

    /**
     * 管理员登录
     * @param    [array]          $params [输入参数]
     */
    public static function Login($params = [])
    {
        // 请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'username',
                'error_msg'         => '用户名不能为空',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'login_pwd',
                'error_msg'         => '密码不能为空',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'username',
                'checked_data'      => 'CheckUserName',
                'error_msg'         => '用户名格式 5~18 个字符（可以是字母数字下划线）',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'login_pwd',
                'checked_data'      => 'CheckLoginPwd',
                'error_msg'         => '密码格式 6~18 个字符',
            ],
        ];
        $ret = ParamsChecked($params, $p);
        if($ret !== true)
        {
            return DataReturn($ret, -1);
        }

        // 获取管理员
        $admin = Db::name('Admin')->field('id,username,login_pwd,login_salt,mobile,login_total,role_id')->where(['username'=>$params['username']])->find();
        if(empty($admin))
        {
            return DataReturn('管理员不存在', -2);
        }

        // 密码校验
        $login_pwd = LoginPwdEncryption($params['login_pwd'], $admin['login_salt']);
        if($login_pwd != $admin['login_pwd'])
        {
            return DataReturn('密码错误', -3);
        }

        // 校验成功
        // session存储
        session('admin', $admin);

        // 返回数据,更新数据库
        if(session('admin') != null)
        {
            $login_salt = GetNumberCode(6);
            $data = array(
                    'login_salt'    =>  $login_salt,
                    'login_pwd'     =>  LoginPwdEncryption($params['login_pwd'], $login_salt),
                    'login_total'   =>  $admin['login_total']+1,
                    'login_time'    =>  time(),
                );
            if(Db::name('Admin')->where(['id'=>$admin['id']])->update($data))
            {
                // 清空缓存目录下的数据
                \base\FileUtil::UnlinkDir(ROOT.'runtime'.DS.'cache');

                return DataReturn('登录成功');
            }
        }

        // 失败
        session('admin', null);
        return DataReturn('登录失败，请稍后再试！', -100);
    }
}
?>