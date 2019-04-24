<?php

namespace app\service;

use app\admin\controller\System;
use PhpMyAdmin\SysInfo;
use think\Db;
use think\facade\Hook;
use app\service\RegionService;

/**
 * 运营管理
 */

class OperationService
{
	public static function CouponList($params = [])
	{
		$data = Db::name('Coupons')->alias('cp')->select();

		foreach ($data as $key => $value) {
			
		}
		return DataReturn('处理成功', 0, $data);
	}

	/**
     * 获取分类节点数据
     * @param    [array]          $params [输入参数]
     */
    /*public static function CouponNodeSon($params = [])
    {
    	// id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        $field = 'id,pid,icon,name,sort,is_enable,bg_color,big_images,vice_name,describe,is_home_recommended';
        $data = Db::name('GoodsCategory')->field($field)->where(['pid'=>$id])->order('sort asc')->select();
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   (Db::name('GoodsCategory')->where(['pid'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['ajax_url']          =   MyUrl('admin/operation/getnodeson', array('id'=>$v['id']));
                $v['delete_url']        =   MyUrl('admin/operation/delete');
                $v['icon_url']          =   ResourcesService::AttachmentPathViewHandle($v['icon']);
                $v['big_images_url']    =   ResourcesService::AttachmentPathViewHandle($v['big_images']);
                $v['json']              =   json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }*/
    public static function CouponNodeSon($params = [])
    {
    	// id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        //$field = 'id,pid,icon,name,sort,is_enable,bg_color,big_images,vice_name,describe,is_home_recommended';

        //->field($field)->where(['pid'=>$id])->order('sort asc')
        $data = Db::name('Coupons')->select();
        
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   (Db::name('Coupons')->where(['id'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['ajax_url']          =   MyUrl('admin/operation/getnodeson', array('id'=>$v['id']));
                $v['delete_url']        =   MyUrl('admin/operation/delete');
                //$v['icon_url']          =   ResourcesService::AttachmentPathViewHandle($v['icon']);
                //$v['big_images_url']    =   ResourcesService::AttachmentPathViewHandle($v['big_images']);
                $v['json']              =   json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }
}
/*
	public static function CouponNodeSon($params = [])
    {
    	// id
        $id = isset($params['id']) ? intval($params['id']) : 0;

        // 获取数据
        //$field = 'id,pid,icon,name,sort,is_enable,bg_color,big_images,vice_name,describe,is_home_recommended';

        //->field($field)->where(['pid'=>$id])->order('sort asc')
        $data = Db::name('Coupons')->select();
        
        if(!empty($data))
        {
            foreach($data as &$v)
            {
                $v['is_son']            =   (Db::name('Coupons')->where(['id'=>$v['id']])->count() > 0) ? 'ok' : 'no';
                $v['ajax_url']          =   MyUrl('admin/operation/getnodeson', array('id'=>$v['id']));
                $v['delete_url']        =   MyUrl('admin/operation/delete');
                $v['icon_url']          =   ResourcesService::AttachmentPathViewHandle($v['icon']);
                $v['big_images_url']    =   ResourcesService::AttachmentPathViewHandle($v['big_images']);
                $v['json']              =   json_encode($v);
            }
            return DataReturn('操作成功', 0, $data);
        }
        return DataReturn('没有相关数据', -100);
    }
*/