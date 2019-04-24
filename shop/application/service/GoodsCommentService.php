<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27
 * Time: 14:21
 */

namespace app\service;



use app\admin\controller\System;
use think\Db;

class GoodsCommentService
{
    /**
     * 删除商品评论
     */
    public static function DelComment($id,$admin)
    {
        // 参数是否有误
        if(empty($id))
        {
            return DataReturn('商品id有误', -1);
        }
        // 开启事务
        Db::startTrans();
        if(DB::name("CommentPhoto")->where("comment_id",$id)->delete() === false){
            Db::rollback();
            return DataReturn('删除评论图片失败', -100);
        }
        $content = Db::name('GoodsComment')->where('id',$id)->value('content');
        if(Db::name('GoodsComment')->delete($id) === false){
            Db::rollback();
            return DataReturn('删除评论失败', -100);
        }
        // 提交事务
        Db::commit();
        $logs = [
            'admin_id'=>$admin['id'],
            'title'=>'删除',
            'detail'=>$admin['username'].'删除了评论：'.$content,
            'add_time'=>time()
        ];
        System::AdminLogSave($logs);
        return DataReturn("删除成功",0);
    }

    /**
     * 修改评论排序
     */
    public static function UpdCommentSort($params){
        $data = Db::name('GoodsComment')->where('id',$params['id'])->update(['sort'=>$params['sort']]);
        if($data){
            return DataReturn("保存成功",0);
        }
        return DataReturn("修改失败",-100);
    }

    /**
     * 获取商品评论
     * @$id : 商品ID
     */
    public static function GetComment($params = [])
    {
        $field = empty($params['field']) ? '*' : $params['field'];
        $order_by = empty($params['order_by']) ? 'sort asc' : trim($params['order_by']);

        $m = isset($params['m']) ? intval($params['m']) : 0;
        $n = isset($params['n']) ? intval($params['n']) : 10;
        $data = Db::name('GoodsComment')->field($field)->where('goods_id',$params['goods_id'])->order($order_by)->limit($m, $n)->select();

        if(empty($data)){
            return DataReturn("暂无评论",-100);
        }
        foreach ($data as &$v){
            $v['imgs'] = Db::name('CommentPhoto')->where(['comment_id'=>$v['id'],'is_show'=>1])->order('sort','asc')->select();
        }
        return DataReturn("success",200,self::GoodsCommmonDataHandle($data));
    }

    /**
     * 处理评论数据
     */
    public static function GoodsCommmonDataHandle($params)
    {
        foreach ($params as $key=>$v){
           $user[]=  Db::name('User')->field('username,avatar')->where('id',$v['user_id'])->select();
        }
        $arr = [];
        if (empty($user)){
            return false;
        }

        foreach ($user as $ke=>$va){
        array_push($arr,['username'=>$va[0]["username"],'avatar'=>$va[0]['avatar'],'p_id'=>$params[$ke]['p_id'],'id'=>$params[$ke]['id'],'add_time'=>date('Y-m-d H:i:s',$params[$ke]['add_time']),'sort'=>$params[$ke]['sort'],'content'=>$params[$ke]['content'],'star'=>$params[$ke]['star'],'imgs'=>$params[$ke]['imgs']]);
    }
        return $arr;
    }
    /**
     * 获取评论总数
     */
    public static function GoodsCommentTotal($id)
    {
            return (int) Db::name('GoodsComment')->where("goods_id",$id)->count();
    }

    /**
     * 获取商品评论详情（评论内容、评论用户）
     */
    public static function GoodsCommentHtml($params = [])
    {
        $data = Db::name("goods_comment")
            ->alias("gc")
            ->where('gc.goods_id',"eq",$params['goods_id'])
            ->join("cms_comment_photo cp","gc.id = cp.comment_id",'left')
            ->join("user user","gc.user_id = user.id",'left')
            ->order("gc.add_time DESC")
            ->field("gc.id,gc.leval,gc.content,gc.sort,gc.add_time,cp.images,user.username,user.avatar")
            ->select();
        return $data;
    }

}