<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/27
 * Time: 11:33
 */

namespace app\service;


use think\Db;

class Area
{
    /**
     * @param $area_id
     * @return 返回省 市 区
     */
    public static function GetAreaName($area_id){
        $data = Db::name('area')->where('area_id',$area_id)->value('area_name');
        return $data;
    }

}