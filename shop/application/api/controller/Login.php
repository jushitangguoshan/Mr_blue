<?php
/**
 * Create by Login
 * author : 蓝先森
 * Date ： 2019/4/18 16:27
 */


namespace app\api\controller;


use app\service\UserService;
use think\Cookie;
use think\Request;
use think\Session;

class Login extends Common
{
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();
    }

    //注册或修改用户信息
    public function UserSave(Request $request){
        if($request->isPost()){
            // 开始操作
            $params = $request->post();
            return UserService::UserSave($params);
        }
    }

    //登录
    public function UserLogin(Request $request){
        if($request->isPost()){
            // 开始操作
            $params = $request->post();
            return UserService::Login($params);
        }

    }

    //验证登录
    public function VerifLogin(){
        if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] > 0){
            return DataReturn('已登录',6,$_COOKIE['user_id']);
        }else{
            return DataReturn('未登录',-2);
        }
    }

}