<?php

namespace app\index\controller;

use app\service\UserService;

/**
 * 用户地址管理
 */
class UserAddress extends Common
{
    /**
     * 构造方法
     * @desc    description
     */
    public function __construct()
    {
        parent::__construct();

        // 是否登录
        $this->IsLogin();
    }
    
    /**
     * [Index 首页]
     */
    public function Index()
    {
        $data = UserService::UserAddressList(['user'=>$this->user]);
        $this->assign('user_address_list', $data['data']);
        return $this->fetch();
    }

    /**
     * [SaveInfo 地址添加/编辑页面]
     */
    public function SaveInfo()
    {
        $this->assign('is_header', 0);
        $this->assign('is_footer', 0);
        
        if(input())
        {
            $params = input();
            $params['user'] = $this->user;
            $data = UserService::UserAddressRow($params);
            $this->assign('data', $data['data']);
        } else {
            $this->assign('data', []);
        }
        return $this->fetch();
    }

    /**
     * [Save 用户地址保存]
     */
    public function Save()
    {
        $params = input('post.');
        $params['user'] = $this->user;
        return UserService::UserAddressSave($params);
    }

    /**
     * 删除地址
     * @desc    description
     */
    public function Delete()
    {
        $params = $_POST;
        $params['user'] = $this->user;
        return UserService::UserAddressDelete($params);
    }

    /**
     * 默认地址设置
     * @desc    description
     */
    public function SetDefault()
    {
        $params = $_POST;
        $params['user'] = $this->user;
        return UserService::UserAddressDefault($params);
    }
}
?>