<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16 0016
 * Time: 11:25
 */

namespace app\api\controller;


use think\Db;

class Config extends Common
{
    /**
     * 计算商品分类是否有子集
     */
    public static function goodsClassifyIsSon($params = 0)
    {
        if(empty($params)){
            return 0;
        }
        $data = Db::name("goods_category")->where("pid",$params['id'])->select();
        if(!$data){
            return 0;
        }
        return $data;
    }
}