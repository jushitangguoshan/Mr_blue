<?php

namespace app\api\controller;

use app\service\IntegralService;
use think\Db;

/**
 * 用户积分管理
 */
class UserIntegral extends Common
{
    /**
     * [__construct 构造方法]
     */
    public function __construct()
    {
        // 调用父类前置方法
        parent::__construct();

        // 是否登录
        $this->Is_Login();
    }

    /**
     * 用户积分列表
     */
    public function Index()
    {
        // 参数
        $params = input();
        $params['user'] = $this->user;

        // 分页
        $number = empty($params['number']) ? 10 : $params['number'];
        $page = max(1, isset($params['page']) ? intval($params['page']) : 1);
        // 条件
        $where = IntegralService::UserIntegralLogListWhere($params);

        // 获取总数
        $total = IntegralService::UserIntegralLogTotal($where);
        $page_total = ceil($total/$number);
        $start = intval(($page-1)*$number);

        // 获取列表
        $data_params = array(
            'm'   => $start,
            'n'  => $number,
            'where'         => $where,
        );
        $data = IntegralService::UserIntegralLogList($data_params);

        // 返回数据
        $result = [
            'total'             =>  $total,
            'page_total'        =>  $page_total,
            'data'              =>  $data['data'],
        ];
        return DataReturn('success', 0, $result);
    }

    /**
     * 站内信系统消息
     */
    public function GetSystemMes(){
        $page = input('page');
        $page = isset($page) ? $page : 1;
        $end = input('limit');
        $limit = isset($end) ? $end : 6;
        $start = ($page-1)*$limit;
        $user_id = input('user_id') ? input('user_id') : 104;
        $arr = [0=>'',1=>'系统公告',2=>'系统通知',3=>'通知后台'];
        $data = Db::name('NoticeLog')->alias('nl')
            ->field('nl.status,n.id,n.type,n.title,n.click,n.add_time')
            ->join('Notice n','nl.notice_id=n.id')
            ->where('nl.to_user_id',$user_id)
            ->where('n.status','<',2)
            ->order('n.add_time','desc')
            ->limit($start,$limit)
            ->select();
        foreach ($data as $k=>&$v){
            $v['type'] = $arr[$v['type']];
        }
        return DataReturn('ok',200,$data);
    }

    /**
     * 站内信详细系统消息
     */
    public function GetSystemMesDetail(){
        $id = input('id');
        $arr = [0=>'',1=>'系统公告',2=>'系统通知',3=>'通知后台'];
        $data = Db::name('Notice')
            ->field('id,type,title,content,click,status,add_time')
            ->where('id',$id)
            ->find();
        $click = $data['click'] +1 ;
        $num = Db::name('Notice')->where('id',$id)->update(['click'=>$click]);
        $data['type'] = $arr[$data['type']];

        return DataReturn('ok',200,$data);
    }

    /**
     * 互动消息
     */
    public function GetInteract(){
        $user_id = 104;
        $data = Db::name('GoodsComment')->where('user_id',$user_id)->select();
    }

    /**
     * 回复
     */
    public function PostInteractMes(){
        $params['goods_id'] = input('goods_id') ? input('goods_id') : 99;
        $params['user_id'] = input('user_id') ? input('user_id') : 99;
        $params['p_id'] = input('comment_id') ? input('comment_id') : 22;
        $params['leval'] = 1;
        $params['content'] = input('content') ? input('content') : 'test';
        $params['star'] = 0;
        $params['add_time'] = time();
        $data = Db::name('GoodsComment')->insertGetId($params);
        if($data){
            $lastData = Db::name('GoodsComment')->where('id',$data)->find();
            return DataReturn('msg',200,$lastData);
        }else{
            return DataReturn('评论出错！',500);
        }
    }

}
?>