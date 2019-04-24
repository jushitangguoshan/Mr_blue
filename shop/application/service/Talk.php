<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 16:53
 */

namespace app\service;


use think\Db;

class Talk
{

    /**
     * 获取客户列表
     */
    public static function GetTalkUser(){
        $data = Db::name('Talk')->field('receive')->order('status','asc')->column('receive');
        $arr = [];
        foreach ($data as $k=>$v){
            if(!in_array($v,$arr) && $v != '客服'){
                $arr[] = $v;
            }
        }
        return $arr;
    }

    //获取用户列表
    public static function GetUserList(){
        $data = Db::name('Talk')->order('status','asc')->order('add_time','desc')->column('receive,status,content');
        $arr = [];
        foreach ($data as $k=>$v){
            $v['content'] = Db::name('Talk')->order('add_time','desc')->where('post',$v['receive'])->whereOr('receive',$v['receive'])->value('content');
            if($k == '客服'){
                unset($data[$k]);
            }else{
                $arr[] = $v;
            }

        }
        return $arr;
    }

    //未读改已读
    public static function Read($params){
        $data = Db::name('Talk')->where('receive',$params['receive'])->where('post',$params['post'])->update(['status'=>1]);
        return $data;
    }

    /**
     * 获取用户聊天记录
     */
    public static function GetUserRecord($username){
        $data = Db::name('Talk')->where(['post'=>$username])->whereOr(['receive'=>$username])->order('add_time asc')->select();
        return $data;
    }

    /**
     * 插入聊天记录
     */
    public static function PostContent($params){
        $params['add_time'] = time();
        if(!Db::name("Talk")->insert($params)){
            return "发送失败！";
        }
        $lastId = Db::name('Talk')->getLastInsID();
        $data = Db::name("Talk")->where('id',$lastId)->select();
        return $data;
    }

    /**
     * 新建用户聊天窗口
     */
    public static function CreateChat($username){
        $params = [
            'post'=>'客服',
            'receive'=>$username,
            'content'=>'您好！再生能源公司，有什么可以帮到您？',
            'status'=>0,
            'add_time'=>time()
        ];
        Db::name('Talk')->insert($params);
        $data = Db::name('Talk')->where('post',$username)->whereOr('receive',$username)->select();
        return $data;
    }



}